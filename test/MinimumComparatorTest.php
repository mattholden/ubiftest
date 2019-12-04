<?
use PHPUnit\Framework\TestCase;
require_once("MockBenchmarkResult.php");

/**
 * Test of MinimumComparator.
 * @author Matt Holden (matt@mattholden.com)
 */
class MinimumComparatorTest extends TestCase
{
   /** 
    * Test proper sorting on sort descending 
    */
   public function testDescending()
   {
        $result = new MockBenchmarkResult();
        $cmp = new MinimumComparator(AbstractComparator::SORT_DESCENDING);
        $comparison = $cmp->compare($result);

        $this->assertEquals(3, count($comparison));
        $this->assertEquals("Function 3", $comparison[0]["name"]);
        $this->assertEquals("Function 2", $comparison[1]["name"]);
        $this->assertEquals("Function 1", $comparison[2]["name"]);
        $this->assertEquals(100, $comparison[0]["value"]);
        $this->assertEquals(10, $comparison[1]["value"]);
        $this->assertEquals(1, $comparison[2]["value"]);
            
            
   }

    /** 
    * Test proper sorting on sort ascending 
    */
   public function testAscending()
   {
        $result = new MockBenchmarkResult();
        $cmp = new MinimumComparator(AbstractComparator::SORT_ASCENDING);
        $comparison = $cmp->compare($result);

        $this->assertEquals(3, count($comparison));
        $this->assertEquals("Function 1", $comparison[0]["name"]);
        $this->assertEquals("Function 2", $comparison[1]["name"]);
        $this->assertEquals("Function 3", $comparison[2]["name"]);
        $this->assertEquals(1, $comparison[0]["value"]);
        $this->assertEquals(10, $comparison[1]["value"]);
        $this->assertEquals(100, $comparison[2]["value"]);
            
   }
}