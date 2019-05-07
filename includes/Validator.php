<?php
/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 18-4-2019
 * Time: 12:17
 */

class Validator
{
    public static function passwordCheck($password, $passwordConfirm) {
        return $passwordConfirm === $password;
    }
}