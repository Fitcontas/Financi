<?php

namespace Financi;

use Opis\Session\Session;

class Flash {

	public $session;

	public function __construct()
	{
		$this->session = new Session();
	}

	public function set($key, $value) 
	{
		$this->session->set($key, $value);
	}

	public function has($key) {
		return $this->session->has($key);
	}

	public function get($key)
	{
		$value = $this->session->get($key);
		$this->session->delete($key);
		return $value;
	}
}