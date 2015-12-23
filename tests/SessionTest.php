<?php

namespace hub20xx\Tests;

use hub20xx\Session;

class SessionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @covers hub20xx\Session::exists
     */
    public function exists_returns_false_if_session_variable_exists()
    {
        $this->assertFalse(Session::exists('variable'));
    }
}
