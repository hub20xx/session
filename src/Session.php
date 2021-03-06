<?php

namespace hub20xx\Session;

use hub20xx\Session\SessionInterface;

/**
 * Session class
 */
class Session implements SessionInterface
{

    /**
     * Starts a session if no active session yet
     */
    public function __construct()
    {
        if (function_exists('session_status')) {
            // PHP >= 5.4.0
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        } else {
            // PHP < 5.4.0
            if (session_id() === '') {
                session_start();
            }
        }
    }

    /**
     * Checks if a session variable exists
     * 
     * @param string $name The name of the session variable
     * @return boolean
     */
    public function exists($name) {
        return ( isset($_SESSION[$name]) ) ? true : false;
    }

    /**
     * Sets a session variable and its value
     * 
     * @param string $name The variable name
     * @param mixed $value The value to be set
     */
    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Gets the value of a session variable by name
     * 
     * @param string $name The variable name
     * @return null|mixed Null if the session variable doesn't exit, the value
     * of the session variable otherwise
     */
    public function get($name)
    {
        return $this->exists($name) ? $_SESSION[$name] : null;
    }

    /**
     * Deletes the session variable by name
     * 
     * @param string $name The variable name
     */
    public function delete($name) 
    {
        if ($this->exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    /**
     * Flashes a session variable by name
     * 
     * The goal is to have a variable to be used only once. We store the 
     * variable in the session with a name. When we flash using the given name,
     * we either
     *  - store the variable in the session using a given name, if there is no
     *  session variable with that name or
     *  - get the variable from the session and delete the session variable.
     * This way we use the variable only once because once it's returned, it's 
     * deleted.
     * 
     * @param string $name The variable name
     * @param value $value The value of the variable
     * @return mixed
     */
    public function flash($name, $value = null)
    {
        if ($this->exists($name)) {
            $value = $this->get($name);
            $this->delete($name);
            return $value;
        } else {
            $this->set($name, $value);
        }
    }
}
