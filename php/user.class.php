<?php

class User {
	private $login;
	private $email;
	private $role;

	function __construct(string $login, string $email, int $role = 0) {
		$this->login = $login;
		$this->email = $email;
		$this->role = $role;
	}

	function getLogin(): string {
		return $this->login;
	}

	function getEmail(): string {
		return $this->email;
	}

	function getRole(): int {
		return $this->role;
	}

}

?>