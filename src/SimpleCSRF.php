<?php
/**
 * SimpleCSRF
 *
 * Class for protection against CSRF
 *
 * @version v2.0.0
 * @author Dmitrii Shcherbakov <atomcms@ya.ru>
 */

namespace DimNS;

class SimpleCSRF {
    /**
     * Length of the random string
     *
     * @var integer
     */
    private $length_random_string = 25;

    /**
     * Name of the session
     *
     * @var string
     */
    private $session_name;

    /**
     * Constructor
     *
     * @param string $session_name Name of the session (default: 'csrf_token')
     *
     * @version v2.0.0
     * @author Dmitrii Shcherbakov <atomcms@ya.ru>
     */
    public function __construct($session_name = 'csrf_token')
    {
        $this->session_name = $session_name;
    }

    /**
     * Getting a token
     *
     * @return string Return result
     *
     * @version v2.0.0
     * @author Dmitrii Shcherbakov <atomcms@ya.ru>
     */
    public function getToken()
    {
        if (isset($_SESSION[$this->session_name])) {
            return $_SESSION[$this->session_name];
        } else {
            $token = uniqid($this->randomString());
            $_SESSION[$this->session_name] = $token;
            return $token;
        }
    }

    /**
     * Checking the token
     *
     * @param string $token The token to check
     *
     * @return boolean Return result
     *
     * @version v2.0.0
     * @author Dmitrii Shcherbakov <atomcms@ya.ru>
     */
    public function validateToken($token)
    {
        if (isset($_SESSION[$this->session_name])) {
            if ($_SESSION[$this->session_name] === $token) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Generate a random string
     *
     * @return string Return result
     *
     * @version v2.0.0
     * @author Dmitrii Shcherbakov <atomcms@ya.ru>
     */
    private function randomString()
    {
        $chars  = 'qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP';
        $max    = $this->length_random_string;
        $size   = strlen($chars) - 1;
        $string = '';

        while ($max--) {
            $string .= $chars[mt_rand(0, $size)];
        }

        return $string;
    }
}
