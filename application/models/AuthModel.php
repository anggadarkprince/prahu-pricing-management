<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class AuthModel
 * @property UserTokenModel $userToken
 */
class AuthModel extends App_Model
{
    protected $table = 'prv_users';

    /**
     * Check user authentication and remembering login.
     *
     * @param string $username
     * @param string $password
     * @param $remember
     * @return bool
     */
    public function authenticate($username, $password, $remember)
    {
        $usernameField = 'username';
        $isEmail = filter_var($username, FILTER_VALIDATE_EMAIL);
        if ($isEmail) {
            $usernameField = 'email';
        }

        $user = $this->db->get_where($this->table, [
            $usernameField => $username
        ]);

        if ($user->num_rows() > 0) {
            $result = $user->row_array();
            if ($result['status'] != UserModel::STATUS_ACTIVATED) {
                return $result['status'];
            }
            $hashedPassword = $result['password'];
            if (password_verify($password, $hashedPassword)) {
                if (password_needs_rehash($hashedPassword, PASSWORD_BCRYPT)) {
                    $newHash = password_hash($password, PASSWORD_BCRYPT);
                    $this->db->update($this->table, ['password' => $newHash], ['id' => $result['id']]);
                }
                $this->session->set_userdata([
                    'auth.id' => $result['id'],
                    'auth.is_logged_in' => true
                ]);

                if ($remember || $remember == 'on') {
                    $this->load->model('UserTokenModel', 'userToken');

                    $loggedEmail = $result['email'];
                    $token = $this->userToken->create($loggedEmail, UserTokenModel::TOKEN_REMEMBER);

                    if ($token) {
                        set_cookie('remember_token', $token, 3600 * 24 * 30);
                        $this->session->set_userdata([
                            'auth.remember_me' => true,
                            'auth.remember_token' => $token
                        ]);
                    }
                }

                return true;
            }
        }
        return false;
    }

    /**
     * Destroy user's session
     */
    public function logout()
    {
        if ($this->session->has_userdata('auth.id')) {
            $this->session->unset_userdata([
                'auth.id', 'auth.is_logged_in', 'auth.remember_me', 'auth.remember_token'
            ]);
            return true;
        }
        return false;
    }

    /**
     * Check if user has logged in from everywhere.
     * @return bool
     */
    public static function isLoggedIn()
    {
        $CI = get_instance();
		$sessionUserId = $CI->session->userdata('auth.id');
		if (is_null($sessionUserId) || $sessionUserId == '') {
			return false;
		}
		if (AuthModel::loginData('status') != 'ACTIVATED') {
			$CI->session->unset_userdata([
				'auth.id', 'auth.is_logged_in', 'auth.remember_me', 'auth.remember_token'
			]);
			flash('danger', 'You are kicked out from session', 'auth/login?force_logout=1');
		}
        return true;
    }

    /**
     * Get authenticate user data.
     * @param string $key
     * @param string $default
     * @return mixed
     */
    public static function loginData($key = '', $default = '')
    {
        $CI = get_instance();
        $id = 0;
        if ($CI->session->has_userdata('auth.id')) {
            $id = $CI->session->userdata('auth.id');
        }
        $result = $CI->db->get_where('prv_users', ['prv_users.id' => $id]);
        $userData = $result->row_array();

        if ($userData == null || count($userData) <= 0) {
            return $default;
        }

        if (!is_null($key) && $key != '') {
            if (key_exists($key, $userData)) {
                return $userData[$key];
            }
            return $default;
        }
        return $userData;
    }
}
