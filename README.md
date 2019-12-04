ParkBench 1.00
=================================

Written for UBreakIFix November 2019 by Matt Holden (matt@mattholden.com)

The key words "MUST", "MUST NOT", "REQUIRED", "SHALL", "SHALL
NOT", "SHOULD", "SHOULD NOT", "RECOMMENDED",  "MAY", and
"OPTIONAL" in this document are to be interpreted as described in
RFC 2119. 
https://tools.ietf.org/rfc/rfc2119.txt

This tool is designed to quickly benchmark different function calls against each other and then report on the results. 

It has three key modules:

The Benchmarker Module
===========================
The benchmarker actually runs the tests. To do this, instantiate a new Benchmark class. Its constructor takes two parameters: an array of callables (more on this below) and an integer indicating how many times to run each method (default: 500). 

This is not a true list of callables, as the tool wouldn't be terribly helpful if it couldn't test functions without parameters. Therefore, each element in the callables array MAY include additional array items after the second (two being the definition of a PHP callable as defined in https://www.php.net/manual/en/language.types.callable.php). The Benchmark class will automatically convert additional array items into parameters and pass them in the order they were received, with the third item in the callable array becoming the first parameter, and so on.

Once your Benchmark is instantiated, call run() to execute the test. The run() method will return a BenchmarkResult class, from which you may obtain each call time (in microseconds) for each call. You can also use the getName() method to get back a string representation of the callable for each item.

The Comparator Module
==========================
Comparators are used by the Reporter to determine how to sort the data. Comparators can be found in the /src/comparators directory and all will extend AbstractComparator. Each child class defines a different type of comparison operation, as is defined in that class's protected doCompare method. 

End users will instantiate the concrete comparator with only a single parameter, whether to sort ascending or descending (constants are provided in the AbstractComparator class). Once it's instantiated, calling the compare() method will return you an associative array in the format: 

[ 
    { name: "the_function_callable_name", "value": "The value returned from doCompare() for this callable" },
    ...
]

This array will be sorted by "value" according to the sort order you specified when instantiating the comparator.

Provided herein are AverageComparator, MedianComparator, MinimumComparator and MaximumComparator.

The Reporter Module
=========================
Reporters use Comparators to format BenchmarkResults according to the Comparator data you request. They can optionally write the data to files. All Reporters extend the AbstractReporter, and must implement the "generateReport" method, which returns a string of the formatted data - which could be HTML, PDF, whatever you want. A sample JSONReporter is included to demonstrate the intended functionality. 

Consumers of the reporter will instantiate a concrete reporter with at least two parameters: the BenchmarkResult to analyze and an array of Comparator objects to report on. You MAY pass a third parameter, a filepath. If you do, the formatted report will be written to the provided file as well as returned as a string.

Ideas for Improvement
=========================
* Add more stock reporters (HTML, PDF, CSV, et. al.)
* Add additional comparators (team: discuss ideas)
* Change the benchmarker to use hrtime() for nanosecond precision once PHP 7.3 has wider adoption
