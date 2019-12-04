<?
use PHPUnit\Framework\TestCase;
require_once("MockBenchmarkResult.php");

/**
 * Test of AverageComparator.

 * @author Matt Holden (matt@mattholden.com)
 */
class AverageComparatorTest extends TestCase
{
   /** 
    * Test proper sorting on sort ascending 
    */
   public function testAscending()
   {
        $result = new MockBenchmarkResult();
        $cmp = new AverageComparator();
        $comparison = $cmp->compare($result);

        $this->assertEquals(3, count($comparison));
        $this->assertEquals("Function 1", $comparison[0]["name"]);
        $this->assertEquals("Function 2", $comparison[1]["name"]);
        $this->assertEquals("Function 3", $comparison[2]["name"]);
        $this->assertEquals(3, $comparison[0]["value"]);
        $this->assertEquals(30, $comparison[1]["value"]);
        $this->assertEquals(300, $comparison[2]["value"]);
            
   }

    /** 
    * Test proper sorting on sort descending 
    */
   public function testDescending()
   {
        $result = new MockBenchmarkResult();
        $cmp = new AverageComparator(AbstractComparator::SORT_DESCENDING);
        $comparison = $cmp->compare($result);

        $this->assertEquals(3, count($comparison));
        $this->assertEquals("Function 3", $comparison[0]["name"]);
        $this->assertEquals("Function 2", $comparison[1]["name"]);
        $this->assertEquals("Function 1", $comparison[2]["name"]);
        $this->assertEquals(300, $comparison[0]["value"]);
        $this->assertEquals(30, $comparison[1]["value"]);
        $this->assertEquals(3, $comparison[2]["value"]);
   }
}