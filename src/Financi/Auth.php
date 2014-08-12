<?php

namespace Financi;

use Opis\Session\Session;

/**
 * @see https://github.com/opis/session
 */
class Auth {
	static function isAuth()
	{
		$session = new Session();
		return $session->get('Auth') ? true : false;
	}

	static function authentication($data = false) 
	{
		if($data) {
			$session = new Session();
			$session->set('Auth', $data);
			return true;
		}
		return false;
	}

	static function logout()
	{
		$session = new Session();
		$session->delete('Auth');

		return true;
	}

	static function getUser() 
	{
		$session = new Session();
		return $session->get('Auth');
	}
}