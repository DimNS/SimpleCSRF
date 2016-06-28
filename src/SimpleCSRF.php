<?php
/**
 * SimpleCSRF
 *
 * Class for protection against CSRF
 *
 * @version v1.0.0
 * @author Dmitrii Shcherbakov <atomcms@ya.ru>
 */

namespace DimNS;

class SimpleCSRF {
    /**
     * Constructor
     *
     * @param string $uniq_string A unique string for the user
     *
     * @version v1.0.0
     * @author Dmitrii Shcherbakov <atomcms@ya.ru>
     */
    public function __construct($uniq_string)
    {
        if (!isset($_SESSION['secret'])) {
            $salt = '$2a$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
            $_SESSION['secret'] = crypt(md5(uniqid(rand(), true)) . $uniq_string, $salt);
        }
    }

    /**
     * Token generation
     *
     * @param string $salt Salt to generate a token for testing. Blank if you want the new token
     *
     * @return string Return result
     *
     * @version v1.0.0
     * @author Dmitrii Shcherbakov <atomcms@ya.ru>
     */
    public function generateToken($salt = '')
    {
        if ($salt === '') {
            $salt = '$2a$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
        }

        return $salt . ':' . crypt($_SESSION['secret'], $salt);
    }

    /**
     * Checking the token
     *
     * @param string $token The token to check
     *
     * @return boolean Return result
     *
     * @version v1.0.0
     * @author Dmitrii Shcherbakov <atomcms@ya.ru>
     */
    public function validateToken($token)
    {
        $args = explode(':', $token);
        if (is_array($args) AND count($args) === 2) {
            $valid_token = $this->generateToken($args[0]);

            if ($valid_token === $token) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
