<?php

namespace hub20xx\Session\Tests;

use hub20xx\Session\Session;

class SessionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @covers hub20xx\Session\Session::__construct
     * @runInSeparateProcess
     */
    public function constructor_starts_a_session_if_no_session_started()
    {
        $noSessionBefore = (session_status() === PHP_SESSION_NONE);
        $session = new Session;
        $sessionAfter = (session_status() === PHP_SESSION_ACTIVE);

        $this->assertTrue($noSessionBefore);
        $this->assertTrue($sessionAfter);
    }

    /**
     * @test
     * @covers hub20xx\Session\Session::__construct
     * @runInSeparateProcess
     */
    public function constructor_does_not_modify_the_current_session_if_session_already_started()
    {
        session_start();
        $sessionActiveBefore = (session_status() === PHP_SESSION_ACTIVE);
        $sessionIdBefore = session_id();
        $session = new Session;
        $sessionIdAfter = session_id();

        $this->assertTrue($sessionActiveBefore);
        $this->assertEquals($sessionIdBefore, $sessionIdAfter);
    }

    /**
     * @test
     * @covers hub20xx\Session\Session::exists
     * @runInSeparateProcess
     */
    public function exists_returns_false_if_session_variable_exists()
    {
        session_unset(); // Make sure session does not contains 'variable'
        $session = new Session;

        $this->assertFalse($session->exists('variable'));
    }

    /**
     * @test
     * @covers hub20xx\Session\Session::exists
     * @runInSeparateProcess
     */
    public function exists_returns_true_if_session_variable_exists()
    {
        session_start(); // Session started somewhere in the code...
        $_SESSION['variable'] = 'value'; // ... a session variable was set

        $session = new Session; // ... we want to use our nice Session class

        $this->assertTrue($session->exists('variable'));
    }

    /**
     * @test
     * @covers hub20xx\Session\Session::set
     * @runInSeparateProcess
     */
    public function set_sets_the_value_of_a_session_variable()
    {
        $session = new Session;
        $session->set('variable', 'value');

        $this->assertEquals('value', $_SESSION['variable']);
    }

    /**
     * @test
     * @covers hub20xx\Session\Session::get
     * @uses hub20xx\Session\Session::set
     * @runInSeparateProcess
     */
    public function get_returns_null_if_session_variable_does_not_exist()
    {
        session_unset(); // Make sure session does not contains 'variable'
        $session = new Session;
        $result = $session->get('variable');

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers hub20xx\Session\Session::get
     * @uses hub20xx\Session\Session::set
     * @runInSeparateProcess
     */
    public function get_returns_the_value_of_a_session_variable_if_it_exists()
    {
        $session = new Session;
        $session->set('variable', 'value');
        $result = $session->get('variable');

        $this->assertEquals('value', $result);
    }

    /**
     * @test
     * @covers hub20xx\Session\Session::delete
     * @uses hub20xx\Session\Session::set
     * @uses hub20xx\Session\Session::get
     * @runInSeparateProcess
     */
    public function delete_deletes_the_session_variable()
    {
        $session = new Session;
        $session->set('variable', 'value');
        $session->delete('variable');
        $result = $session->get('variable');

        $this->assertEquals(null, $result);
    }

    /**
     * @test
     * @covers hub20xx\Session\Session::flash
     * @uses hub20xx\Session\Session::set
     * @uses hub20xx\Session\Session::get
     * @runInSeparateProcess
     */
    public function flash_returns_the_value_of_a_session_variable_and_deletes_the_session_variable_if_the_session_variable_exists()
    {
        $session = new Session;
        $session->set('variable', 'value');
        $result = $session->flash('variable');
        $valueAfterFlash = $session->get('variable');

        $this->assertEquals('value', $result);
        $this->assertNull($valueAfterFlash);
    }

    /**
     * @test
     * @covers hub20xx\Session\Session::flash
     * @uses hub20xx\Session\Session::get
     * @runInSeparateProcess
     */
    public function flash_sets_the_value_of_a_session_variable_if_the_session_variable_does_not_exists()
    {
        session_unset(); // Make sure session does not contains 'variable'
        $session = new Session;
        $session->flash('variable', 'value');
        $result = $session->get('variable');

        $this->assertEquals('value', $result);
    }
}
