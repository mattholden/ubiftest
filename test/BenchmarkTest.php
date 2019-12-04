<?
use PHPUnit\Framework\TestCase;
require_once("IDoNothing.php");

/**
 * Test out the benchmark class. Not an awful lot to test here because we don't know what the actual 
 * benchmarks will return.

 * @author Matt Holden (matt@mattholden.com)
 */
class BenchmarkTest extends TestCase
{
    private $testThing = null;

    /**
     * Generate a benchmark.
     * @return Benchmark the benchmark we built.
     */
    private function makeBenchmark() : \Benchmark
    {
        if ($this->testThing === null) {
            $this->testThing = new IDoNothing();
        }
        
        $callers = [

            [ $this->testThing, "uselessMethod" ],
            [ "IDoNothing", "staticMethod" ],
            [ $this->testThing, "uselessMethodWithParams", "Test String" ] 
        ];

        $bench = new \Benchmark($callers, 100);
        return $bench;
    }

    /**
     * Test that we can get names properly out of the result
     */
    public function testNames()
    {
        $result = $this->makeBenchmark()->run();

        $this->assertEquals("IDoNothing::uselessMethod", $result->getName(0));
        $this->assertEquals("IDoNothing::staticMethod", $result->getName(1));
        $this->assertEquals("IDoNothing::uselessMethodWithParams ([\"Test String\"])", $result->getName(2));
        
    }

    /** 
     * Test that counts are accurate and match expected results
     */ 
    public function testCountsMatch()
    {
        $result = $this->makeBenchmark()->run();
 
        $runs = $result->getRunCount();
        $calls = $result->getCallablesCount();
        $this->assertEquals(100, $runs);
        $this->assertEquals(3, $calls);

        for ($i = 0; $i < $calls; $i++) {
            $this->assertEquals($runs, count($result->getResults($i)));  
        }

        $this->expectException(Exception::class);
        $result->getResults(100);
    }

}