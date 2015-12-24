<?php

namespace hub20xx\Session;

interface SessionInterface
{

    /**
     * Checks if a session variable exists
     * 
     * @param string $name The name of the session variable
     * @return boolean
     */
    public function exists($variable);

    /**
     * Sets a session variable and its value
     * 
     * @param string $name The variable name
     * @param mixed $value The value to be set
     */
    public function get($variable);

    /**
     * Gets the value of a session variable by name
     * 
     * @param string $name The variable name
     * @return null|mixed Null if the session variable doesn't exit, the value
     * of the session variable otherwise
     */
    public function set($variable, $value);

    /**
     * Deletes the session variable by name
     * 
     * @param string $name The variable name
     */
    public function delete($variable);

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
    public function flash($variable, $value);

}
