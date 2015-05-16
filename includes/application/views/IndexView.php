<?php

require_once __DIR__ . '/AbstractView.php';

/**
 * The index page.
 * @author Michael
 */
final class IndexView extends AbstractView
{
	/**
	 * Creates a new {@link IndexView}.
	 * @param $smarty Smarty The smarty template.
	 */
	public function __construct($smarty)
	{
		parent::__construct('index', 'M2M Connect', $smarty);
	}
}
