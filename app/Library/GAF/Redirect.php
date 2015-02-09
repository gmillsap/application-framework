<?php
namespace GAF;

class Redirect
{
    protected static $home = 'Location: /';

    public static function toHome() {
        header(self::$home);
    }

    public static function withCode($code) {
        header(Response::getHTTPResponseHeader($code));
    }
}