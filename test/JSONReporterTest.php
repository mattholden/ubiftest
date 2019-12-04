<?
use PHPUnit\Framework\TestCase;
require_once("MockBenchmarkResult.php");

/**
 * Test of JSONReporter.
 * @author Matt Holden (matt@mattholden.com)
 */
class JSONReporterTest extends TestCase
{
   /** 
    * Test report generation with multiple comparators
    */
   public function testReport()
   {
     $mock = new MockBenchmarkResult();
     $comps = [ new MinimumComparator(), new AverageComparator(AverageComparator::SORT_DESCENDING) ];
     $report = new JSONReporter($mock, $comps);
     $this->assertEquals('{"Minimum (asc)":[{"name":"Function 1","value":1},{"name":"Function 2","value":10},{"name":"Function 3","value":100}],"Average (desc)":[{"name":"Function 3","value":300},{"name":"Function 2","value":30},{"name":"Function 1","value":3}]}', trim($report->run())); 
  }

   /*  Don't do test with file i/o; this can be super slow when there's lots of them, 
       and also can cause permissions issues when running in CI/CD environments. */

}