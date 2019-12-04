<?

/**
 * Comparator to rank benchmark results by their median execution time. 
 
 * @author Matt Holden (matt@mattholden.com)
 */
class MedianComparator extends AbstractComparator
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
            
            $values = $result->getResults($i);
            asort($values); // sort order doesn't matter; the middle will be the same either way
            $runs = $result->getRunCount();

            $middleval = floor(($runs-1)/2); 
            if ($runs % 2) { 
                $median = $values[$middleval];
            } else {
                $low = $values[$middleval];
                $high = $values[$middleval+1];
                $median = (($low+$high)/2);
            }
            $results[strval($i)] = $median;
        }
        return $results;
    }
}