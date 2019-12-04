<?

/**
 * A class for describing benchmark results. 
 * 
 * @author Matt Holden (matt@mattholden.com)
 */
class BenchmarkResult
{
    private $runData;
    private $names;

    /**
     * Build the result class from the data the benchmark tool spits out. 
     * @param $data array a 2D array containing all of the individual runs.
     * @param $names array An array of report-friendlier names for the callables. 
     */
    public function __construct(array $data, array $names) 
    {
        $this->runData = $data;
        $this->names = $names;
    }

    /**
     * Get the number of callables that were originally tested.
     * @return int the number of callables.
     */
    public function getCallablesCount() : int
    {
        return count($this->runData);
    }

    /**
     * Get the number of times that the callables that were originally tested.
     * @return int the number of runs.
     */
    public function getRunCount() : int
    {
        return count($this->runData[0]);
    }

    /** 
     * Get the results from a given call.
     * @param $call int the call to get results for. 
     * @return array the results
     * @throws Exception if the call you requested doesn't exist. 
     */
    public function getResults(int $call) : array
    {
        if (!isset($this->runData[$call])) {
            throw new \Exception("Invalid callable requested in BenchmarkResult.");
        }
        return $this->runData[$call];
    }

    /**
     * Get the name for a given callable. 
     * @param $call int the call to get the name for. 
     * @return string the name
     * @throws Exception if the call doesn't exist. 
     */
    public function getName(int $call) : string
    {
        if (!isset($this->names[$call])) {
            throw new \Exception("Invalid callable requested in BenchmarkResult.");
        }
        return $this->names[$call]; 
    }
}