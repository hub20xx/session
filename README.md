# Session

[![Build Status](https://travis-ci.org/hub20xx/session.svg)](https://travis-ci.org/hub20xx/session)

A simple session class.

## Install

Via Composer

```bash
$ composer require hub20xxx/session
```

## Usage

You can use the class to store / retrieve anything that can be stored in a php session.


```php
// Forget about session_start():
//   - current session left alone if present
//   - new session started if no session present
$session = new \hub20xxx\Session\Session;

// Checking the existence of a session variable
$session->exists('variable'); // returns a boolean

// Setting session variables
$session->set('myString', 'stringy string');
$session->set('myArray', ['key' => 'value', 'otherKey' => 'otherValue']);
$session->set('myClass', new StdClass);

// Getting values of session variables
$mySessionString = $session->get('myString');
$mySessionArray = $session->get('myArray');
$mySessionClass = $session->get('myClass');

// Deleting session variables
$session->delete('myString');
$session->delete('myArray');
$session->delete('myClass');

// Flashing session variables
// 1. Setting the session variable (you can use the set method as well)
$session->flash('myFlashString', 'stringy string');
$session->flash('myFlashArray', ['key' => 'value', 'otherKey' => 'otherValue']);
$session->flash('myFlashClass', new StdClass);

// 2. Getting values of session variables and deleting them
$myFlashString = $session->flash('myFlashString');
$myFlashArray = $session->flash('myFlashArray');
$myFlashClass = $session->flash('myFlashClass');
```

## Testing

```bash
$ phpunit
```

## License

[MIT](LICENSE.md)

