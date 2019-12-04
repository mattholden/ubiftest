<?

error_reporting(E_ALL | E_STRICT); 

/////////////////////////////////////////////////////
// CLASS LOADING
/////////////////////////////////////////////////////
spl_autoload_register(function ($claszName) {
    
    $className = $claszName;
    //                                          
    $path = [ "", "/comparators", "/reporters" ];
    foreach ($path as $dir) {

        $p = __DIR__ . $dir;
        $file = $p . "/" . $className . ".php";
        if (is_readable($file)) {
            require_once($file);
            return;
        }

        $file = $p ."/" . strtolower($className) . ".php";
        if (is_readable($file)) {
            require_once($file);
            return;
        }
    }
});