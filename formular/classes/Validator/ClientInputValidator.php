<?php
namespace Validator;


class ClientInputValidator
{
    public static function isValidName($name)
    {
        $name_regex = '/^(?:\p{L}|[_\-]){3,25}$/u';
        return preg_match($name_regex, $name);
    }

    public static function isValidTel($tel)
    {
        $tel_regex = '/^[0-9\+][0-9\ ]{9,12}$/';
        return preg_match($tel_regex, $tel);
    }

    public static function isValidIco($ico)
    {
        $ico_regex = '/^[0-9]{8}$/';
        return preg_match($ico_regex, $ico);
    }

    public static function isValidDic($dic)
    {
        $dic_regex = '/^[0-9]{10}$/';
        return preg_match($dic_regex, $dic);
    }

}