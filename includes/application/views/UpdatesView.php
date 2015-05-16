<?php

require_once __DIR__ . '/AbstractView.php';

/**
 * Displays the results of a 'check updates' action.
 * @author Michael
 */
final class UpdatesView extends AbstractView
{
	/**
	 * Creates a new {@link UpdatesView}.
	 * @param $smarty Smarty The smarty template.
	 */
	public function __construct($smarty)
	{
		parent::__construct('updates', 'Check Updates', $smarty);

		$smarty->assign('updates', array());
	}

	/**
	 * Adds a {@link CircuitBoard} update to this view.
	 * @param $update CircuitBoard The update to add.
	 */
	public function addUpdate($update)
	{
		$this->smarty->append('updates', $update);
	}

}
