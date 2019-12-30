<?php

class RedirectIfAuthenticated
{
	private $homePage = 'app';

	private $mustRedirectIfAuthenticated = [
		Login::class, Register::class, Password::class
	];

	/**
	 * Check if user is authenticated.
	 * @param string $homeUrl
	 */
	public function isGuest($homeUrl)
	{
		$controller = get_class(get_instance());

		foreach ($this->mustRedirectIfAuthenticated as $guestController) {
			if ($controller == $guestController) {
				if (AuthModel::isLoggedIn()) {
					if (empty($homeUrl)) {
						redirect($this->homePage);
					}
					redirect($homeUrl);
				}
			}
		}
	}
}
