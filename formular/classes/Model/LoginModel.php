<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 2016.11.28.
 * Time: 12:04
 */

namespace Model;


class LoginModel extends AbstractModel
{
    public function doLogin($userName, $pass)
    {
        if ($pass != '') $pass = sha1($pass);
        $sql = '
            SELECT 
                fk_role
            FROM public.users
            WHERE
                login=:login AND password=:password
        ';

        $result = $this->query($sql, array(':login' => $userName, ':password' => $pass));
        if (count($result) == 0) return null;
        return $result[0];
    }
}