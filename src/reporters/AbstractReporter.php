<?

/**
 * Abstract report class. Extend this to add different types of output. 
 * @author Matt Holden (matt@mattholden.com)
 */
abstract class AbstractReporter
{
    private $filename = null;
    private $comparators = null;
    private $result = null;
    private $comparedResults = null;

    /** 
     * Construct the report. 
     * @param $result \BenchmarkResult The result to report on.
     * @param $comparators array An array of one or more comparators to run on the result and report on.
     * @param $filename string|null The file name to output to. If this is null, echo the results in the
     * requested format to the terminal/browser.
     */
     public function __construct(\BenchmarkResult $result, array $comparators, ?string $filename = null)
     {
        $this->result = $result;
        $this->filename = $filename;
        $this->comparators = $comparators;
    }

    /**
     * Run the report. Writes it to a file if you specified a filename in the constructor.
     * @return string the report data in case you want to echo to browser or test with it.
     * @throws Exception if there was a file writing error
     */
     public function run()
     {  
        $report = $this->generateReport();
        if ($this->filename !== null) {
            $file = fopen($this->filename, "wb");
            if ($file === false) { 
                throw new \Exception("File ".$file." could not be opened for writing.");
            }
            fwrite($file, $report);
            fclose($file);
        }
        return $report;
     }

     /** 
      * Get the raw result. 
      * @return \BenchmarkResult the raw result.
      */
     public function getBenchmarkResult() : \BenchmarkResult
     {
        return $this->result;
     }

     /**
      * Get the compared results.
      * @return array An array of results, one per comparator
      */
     public function getComparedResults() : array
     {
        if ($this->comparedResults === null) {
            $this->comparedResults = [];
            foreach ($this->comparators as $comp) {
                $key = str_replace("Comparator", "", get_class($comp));
                $key .= $comp->isSortAscending() ? " (asc)" : " (desc)";
                $this->comparedResults[$key] = $comp->compare($this->result);
            }
        }
        return $this->comparedResults;
     }

     /**
      * Generate the report in the requested format. 
      * @return string The report in the requested format.
      */
     protected abstract function generateReport();

}