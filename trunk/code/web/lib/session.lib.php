<?php

final class session
{
    public static $is_login = false;
    public static $user_info = array();

    public static function init()
    {
        self::$is_login = false;
    }
}

?>
