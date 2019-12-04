<?

/**
 * Reporter to spit out results in JSON.
 * @author Matt Holden (matt@mattholden.com)
 */
class JSONReporter extends AbstractReporter
{
    /**
     * Run the report and put it where you asked us to.
     * @throws Exception if there was a file writing error
     */
    protected function generateReport() : string
    {
        return json_encode($this->getComparedResults()); 
    }
}