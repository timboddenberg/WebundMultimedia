<?php

class DatabaseEngine
{
    public static function getConnection()
    {
        return new mysqli("localhost", "root", "", "webundmultimedia");
    }

}