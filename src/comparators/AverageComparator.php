<?

/**
 * Comparator to rank benchmark results by their average execution time. 
 * @author Matt Holden (matt@mattholden.com)
 */
class AverageComparator extends AbstractComparator
{   
    /**
     * Perform the desired comparison operation. 
     * @param $benchmark \BenchmarkResult a benchmark result to compare.
     * @return A list of array indexes, corresponding to the callables that were executed, and their values.
     */
    protected function doCompare(\BenchmarkResult $result) : array
    {
        $results = [];
        for ($i = 0; $i < $result->getCallablesCount(); $i++) {
            $results[$i] = array_sum($result->getResults($i))/$result->getRunCount();
        }
        return $results;
    }
}