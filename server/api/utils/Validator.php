<?php

Class Validator
{
    static function checkPassword($pass)
    {
        return strlen($pass)>5? true : false;
    }

    static function checkLogin($login)
    {
       return preg_match("/^[a-zA-Z0-9]+$/",$login) && strlen($login)>3? true : false;
    }

    static function checkId($id)
    {
       return !empty($id) && preg_match("/^[0-9]+$/", $id)? true:false;
    }

    static function clearData($data)
    {
        $clearString = mb_strtolower(strip_tags($data));
        return trim($clearString);
    }
}
