<?php

namespace zoge\barion\common;

abstract class Currency
{
    const HUF = "HUF";
    const EUR = "EUR";
    const USD = "USD";
    const CZK = "CZK";

    public static function isValid($name)
    {
        $class = new ReflectionClass(__CLASS__);
        $constants = $class->getConstants();
        return array_key_exists($name, $constants);
    }
}