<?php

require_once __DIR__ . '/AbstractView.php';
require_once __DIR__ . '/../../../test/application/M2MTestSuite.php';

/**
 * The debug page.
 * @author Michael
 */
final class DebugView extends AbstractView
{
	/**
	 * Creates a new {@link DebugView}.
	 * @param $smarty Smarty The smarty template.
	 */
	public function __construct($smarty)
	{
		parent::__construct('debug', 'Debug', $smarty);

		/* fetch the test suite page */
		try {
			ob_start();
			$test = new M2MTestSuite();
			$test->run(new HtmlReporter());
		} finally {
			$this->smarty->assign('testResults', ob_get_clean());
		}
	}
}
