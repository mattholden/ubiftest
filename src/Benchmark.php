<?

/**
 * Tool to benchmark PHP functions. 
 * To use, simply call the constructor with an array of callables.
 * 
 * @author Matt Holden (matt@mattholden.com)
 */
class Benchmark
{
    private $timesToRun;
    private $callables = null;
   
    /**
     * Instantiate the class. Call run() to actually run the benchmark.
     *
     * @param $callables array An array of methods to call. Each element should itself be a "callable" array.
     *                         Any elements after the second in each callable array will be passed as parameters
     *                         to the callable function.
     *  
     * @param $timesToRun int  The number of times to call the method(s). Defaults to 500.
     * @throws Exception if we couldn't figure out how to turn your $callables into an array of callables.
     */
    public function __construct(array $callables, int $timesToRun = 500)
    {
        $this->timesToRun = $timesToRun;
        $this->callables = $callables;
        
        foreach ($this->callables as $callable) {
            
            // Check if each element is callable. If it's not, it might be because we passed extra stuff to use as
            // parameters, so let's test that before we fail out.
            if (!is_callable($callable)) {

                if (is_array($callable) && count($callable) > 2) {
                    $maybeCallableAfterAll = [ $callable[0], $callable[1] ];
                    
                    if (!is_callable($maybeCallableAfterAll)) {
                        throw new \Exception("Some of the items in your callables array were not callable. Benchmark cannot proceed.");
                    }
                }
                else {
                    throw new \Exception("Some of the items in your callables array were not callable. Benchmark cannot proceed.");
                }
            }
        }
    }

    /**
     * Simple accessor for the callables passed to the constructor.
     * @return array An array of "probably" callables - it may contain additional elements that will be parameters.
     */
    public function getCallables() : array
    {
        return $this->callables;
    }

    /** Simple accessor for the times to run the benchmark.
     * @return int The number of times to run the benchmark. 
     */
    public function getTimesToRun() : int
    {
        return $this->timesToRun;
    }

    /**
     * Actually run the benchmark. 
     * @return \BenchmarkResult the result of the benchmark operation.
     */
    public function run() : \BenchmarkResult
    {
        $results = [];
        $callableNames = [];

        // Don't trust the internal variables -- somebody might extend this class. 
        $callables = $this->getCallables();
        $times = $this->getTimesToRun();

        foreach ($callables as $callable) {

            $result = [];
            $params = [];

            // See if we need to mangle the array to make it truly callable
            if (count($callable) > 2) {
                $params = array_slice($callable, 2);
                $callable = array_slice($callable, 0, 2);   
            }    

            // generate a reportable name for the callable
            $callableName = "";
            if (is_string($callable[0])) {
                $callableName = $callable[0];
            }
            else {
                $callableName = get_class($callable[0]);
            }
            $callableName .= "::" .$callable[1];
            if (count($params) > 0) {
                $callableName .= " (".json_encode($params) . ")";
            }
            $callableNames[] = $callableName;
          
            for ($i = 0; $i < $times; $i++) {

                // Would have loved to use hrtime() but PHP 7.3 isn't available on my hosted VPS at the moment ;(
                // https://www.php.net/manual/en/function.hrtime.php
                $timeElapsed = -1 * microtime(true);
                call_user_func_array($callable, $params);
                $timeElapsed += microtime(true);

                // this is a teeny tiny float. Let's make it more readable by turning it into microseconds. 
                $result[] = $timeElapsed * 100000;
            }

            $results[] = $result;
        }
        return new BenchmarkResult($results, $callableNames);
    }

}