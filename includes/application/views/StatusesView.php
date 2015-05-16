<?php

require_once __DIR__ . '/AbstractView.php';

/**
 * Displays the results of a 'view statuses' action.
 * @author Michael
 */
final class StatusesView extends AbstractView
{
	/**
	 * Creates a new {@link StatusesView}.
	 * @param $smarty Smarty The smarty template.
	 */
	public function __construct($smarty)
	{
		parent::__construct('statuses', 'View Statuses', $smarty);

		$smarty->assign('boards', array());
	}

	/**
	 * Adds a circuit board to this view.
	 * @param $board CircuitBoard The circuit boar.
	 */
	public function addBoard($board)
	{
		$this->smarty->append('boards', $board);
	}
}
