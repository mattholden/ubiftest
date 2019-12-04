<?

/**
 * Abstract class modeling a single way we can compare the results of a Benchmark. 
 * 
 * Should be extended for each new type of comparison we wish to support.
 * @author Matt Holden (Matt@mattholden.com)
 */
abstract class AbstractComparator 
{
    /** Sort the results ascending */
    public const SORT_ASCENDING = true;

    /** Sort the results descending */
    public const SORT_DESCENDING = false;

    /** @var $sortOrder What the current sort order is */
    private $sortOrder;

    /**
     * Get the sort order. 
     * @return boolean true if we are sorting ascending, false otherwise
     */
    public function isSortAscending() : bool 
    {
        return $this->sortOrder;
    }

    /**
     * Instantiate a comparator. 
     * @param $sortOrder bool The sort order to use. Default: SORT_ASCENDING
     */
    public function __construct(bool $sortOrder = self::SORT_ASCENDING)
    {
        $this->sortOrder = $sortOrder;
    }

    /**
     * Run the comparison and sort the data.
     * @param $benchmark \BenchmarkResult a benchmark result to compare.
     * @return array An array containing the callable indices in the order requested and their corresponding values. 
     */
    public function compare(\BenchmarkResult $result) : array
    {
        $toSort = $this->doCompare($result);
        if ($this->sortOrder) { 
            asort($toSort);
        }
        else {
            arsort($toSort);
        }
        $values = [];
        foreach ($toSort as $k=>$v) {
            $values[] = [ "name" => $result->getName($k), "value" => $v ];
        }
        return $values;
    }

    /**
     * Perform the desired comparison operation. 
     * @param $benchmark \BenchmarkResult a benchmark result to compare.
     * @return An array in which the keys are the callable indexes and the values are the result to compare.
     */
    protected abstract function doCompare(\BenchmarkResult $benchmark) : array;


}