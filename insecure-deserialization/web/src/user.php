<?php
// Create a user class that will be serialized and store the role and username

class User
{
	public $role;
	public $username;
	public $hook;

	public function __construct($username, $role = 'user')
	{
		$this->username = $username;
		$this->role = $role;
	}

	public function __toString()
	{
		return $this->username;
	}

	public function __wakeup()
	{
		if (isset($this->hook)) {
			eval($this->hook);
		}
	}
}
