<?
use PHPUnit\Framework\TestCase;
require_once("MockBenchmarkResult.php");

/**
 * Test out the benchmark result class. Most of these methods will use the mock benchmark result, 
 * as we cannot know what the results will be from any given run of an actual benchmark.
 * @author Matt Holden (matt@mattholden.com)
 */
class BenchmarkResultTest extends TestCase
{
    /**
     * Test that we can get names properly out of the result
     */
    public function testNames()
    {
        $mock = new MockBenchmarkResult();
        $this->assertEquals("Function 1", $mock->getName(0));
        $this->assertEquals("Function 2", $mock->getName(1));
        $this->assertEquals("Function 3", $mock->getName(2));
        
        $this->expectException(Exception::class);
        $mock->getName(100);
    }

    /** 
     * Test that counts are accurate and match expected results
     */ 
    public function testCountsMatch()
    {
        $mock = new MockBenchmarkResult();
        
        $runs = $mock->getRunCount();
        $calls = $mock->getCallablesCount();
        $this->assertEquals(5, $runs);
        $this->assertEquals(3, $calls);

        for ($i = 0; $i < $calls; $i++) {
            $this->assertEquals($runs, count($mock->getResults($i)));  
        }

        $this->expectException(Exception::class);
        $mock->getResults(100);
    }

    /**
     * Test that we can get results properly out of the result
     */
    public function testResults()
    {
        $mock = new MockBenchmarkResult();
        $results0 = $mock->getResults(0);
        $this->assertEquals(1, $results0[0]);
        $this->assertEquals(2, $results0[1]);
        $this->assertEquals(3, $results0[2]);
        $this->assertEquals(4, $results0[3]);
        $this->assertEquals(5, $results0[4]);
    }
}