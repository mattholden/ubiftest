<?

/**
 * Comparator to rank benchmark results by their minimum execution time. 
 * @author Matt Holden (matt@mattholden.com)
 */
class MinimumComparator extends AbstractComparator
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
            $index = strval($i);
            $results[$index] = 1999999999;

            $runs = $result->getResults($i);
            foreach ($runs as $run) {
                if ($run < $results[$index]) {
                    $results[$index] = $run;
                }
            }
        }
        return $results;
    }
}