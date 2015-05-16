<?php

/**
 * Represents a 'View' in the MVC pattern.
 * @author Michael
 */
abstract class AbstractView
{

	/**
	 * The string identifier of this page.
	 * @var string
	 */
	protected $id;

	/**
	 * The title of this page.
	 * @var string
	 */
	protected $title;

	/**
	 * The smarty template.
	 * @var Smarty
	 */
	protected $smarty;

	/**
	 * Creates a new {@link AbstractView}.
	 * @param $id string The string identifier of this page.
	 * @param $title string The page title.
	 * @param $smarty Smarty The smarty template.
	 */
	protected function __construct($id, $title, $smarty)
	{
		$this->id = $id;
		$this->title = $title;
		$this->smarty = $smarty;
	}

	public final function applyTemplate($loggedIn) {
		/* set up page template */
		$this->smarty->assign('title', $this->title);

		$leftNav =
			array(
				array('id' => 'index', 'title' => 'Home', 'icon' => 'home', 'class' => ''),
				array('id' => 'statuses', 'title' => 'View Statuses', 'icon' => 'statuses', 'class' => ''),
			);

		$rightNav =
			array(
				array('id' => 'register', 'title' => 'Register', 'icon' => 'register', 'class' => ''),
				array('id' => 'login', 'title' => 'Login', 'icon' => 'login', 'class' => '')
			);

		/* alter nav bar if we are logged in */
		if ($loggedIn) {
			$this->smarty->assign('loggedInNav', '<li><span class="menu icon-user"></span>' . $_SESSION['username'] . '</li>');

			$rightNav =
				array(
					array('id' => 'logout', 'title' => 'Logout', 'icon' => 'logout', 'class' => '')
				);

			if ($_SESSION['rank'] === 'ADMIN') {
				array_push($leftNav,
					array('id' => 'updates', 'title' => 'Check Updates', 'icon' => 'updates', 'class' => '')
				);

				if (DEBUG_MODE) {
					array_push($leftNav,
						array('id' => 'debug', 'title' => 'Debug', 'icon' => 'debug', 'class' => '')
					);
				}
			}
		}

		for ($i = 0; $i < count($leftNav); $i++) {
			$nav = $leftNav[$i];

			if ($nav['id'] === $this->id) {
				$leftNav[$i]['class'] = ' class="current"';
			}
		}

		for ($i = 0; $i < count($rightNav); $i++) {
			$nav = $rightNav[$i];

			if ($nav['id'] === $this->id) {
				$rightNav[$i]['class'] = ' class="current"';
			}
		}

		$this->smarty->assign('leftNav', $leftNav);
		$this->smarty->assign('rightNav', $rightNav);
		$this->smarty->assign('navCurrent', $this->id);
	}

	/**
	 * Gets the string identifier of this page.
	 * @return string The string identifier of this page.
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Gets the title of this page.
	 * @return string The title of this page.
	 */
	public function getTitle()
	{
		return $this->title;
	}
}
