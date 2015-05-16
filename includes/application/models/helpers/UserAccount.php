<?php

/**
 * Represents a user account.
 * @author Michael
 */
final class UserAccount
{
	/**
	 * The account username.
	 * @var string
	 */
	private $username;

	/**
	 * The hashed account password.
	 * @var string
	 */
	private $passwordHash;

	/**
	 * The account rank.
	 * @var string
	 */
	private $rank;

	/**
	 * Creates a new {@link UserAccount}.
	 * @param $username string The username.
	 * @param $passwordHash string The hashed password.
	 * @param $rank string The rank.
	 */
	public function __construct($username, $passwordHash, $rank)
	{
		$this->username = $username;
		$this->passwordHash = $passwordHash;
		$this->rank = $rank;
	}

	/**
	 * Generates a string representation of this {@link UserAccount}.
	 * @return string A string representation of this {@link UserAccount}.
	 */
	public function __toString()
	{
		return "Username=\"$this->username\", Rank=\"$this->rank\"";
	}

	/**
	 * Gets the account's username.
	 * @return string The account's username.
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * Gets the account's hashed password.
	 * @return string The account's hashed password.
	 */
	public function getPasswordHash()
	{
		return $this->passwordHash;
	}

	/**
	 * Gets the account's rank.
	 * @return string The account's rank.
	 */
	public function getRank()
	{
		return $this->rank;
	}
}
