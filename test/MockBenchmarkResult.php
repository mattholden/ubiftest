<?

/**
 * Mock BenchmarkResult for predictable results so we can do test cases.
 *
 * @author Matt Holden (matt@mattholden.com)
 */
 class MockBenchmarkResult extends BenchmarkResult
 {

    /**
     * Build the result class from the data the benchmark tool spits out.
     */
    public function __construct() 
    {
        $result = [
            [ 1, 2, 3, 4, 5 ],
            [ 10, 20, 30, 40, 50 ],
            [ 100, 200, 300, 400, 500 ]
        ];
        $names = [ "Function 1", "Function 2", "Function 3" ];
        parent::__construct($result, $names);
    }

 }