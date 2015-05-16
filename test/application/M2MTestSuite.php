<?php
/**
 * @author Michael
 */

require_once __DIR__ . '/../../includes/library/simpletest/collector.php';
require_once __DIR__ . '/../../includes/library/simpletest/reporter.php';
require_once __DIR__ . '/../../includes/library/simpletest/unit_tester.php';


class M2MTestCase extends UnitTestCase {
	/* as the simpletest expectException acts for an entire method this allows a call to expect a single exception */
	function assertException($exception, $function, $parameters = array()) {
		try {
			call_user_func_array($function, $parameters);
			$this->fail("Expected exception of type $exception but function succeeded.");
		} catch (Exception $e) {
			$this->assertIdentical(get_class($e), $exception, "Expected exception of type $exception but got " . get_class($e) . ".");
		}
	}
}

final class M2MTestSuite extends TestSuite {
	public function M2MTestSuite() {
		$this->TestSuite('Unit Testing Results');
		$this->collect(__DIR__ . '/controllers/helpers', new SimpleCollector());
	}
}
