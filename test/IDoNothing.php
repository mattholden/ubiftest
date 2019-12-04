<?

/**
 * This is a dummy class to provide methods to call for testing.
 * 
 * @author Matt Holden (matt@mattholden.com)
 */
 class IDoNothing
 {
    /**
     * Doesn't do anything useful. Here to have methods to call. 
     */
    public function uselessMethod() 
    {
        // Let's make it at least pretend to do a thing.
        $x = 1 + 2 + 3 * 4;
    }

    /** 
      * This doesn't do anything either, but it does it STATICALLY! 
      * @return string A very important message from the author. 
      */
    public static function staticMethod() : string
    {
        return "I sure hope I get the job at UBreakIFix!";
    }

    /** 
     * This method takes parameters! Ooo, fancy! Still doesn't do anything with them though. 
     *  @param $foo string|null Send me a string. I'll... contemplate it, I suppose. 
     */
     public function uselessMethodWithParams(?string $param = null) : string
     {
        if ($param === null) {
            $param = "*shrug*";
        }   

        // waste a few cycles so we have something to benchmark.
        $x = 42*42*42 + 12345;
        $x /= 1126;

        return "You wanted me to tell you {$param} for some reason. Yay testing!";
     }
 }
