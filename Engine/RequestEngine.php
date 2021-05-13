<?php

class RequestEngine
{
    public function GET(string $key)
    {
        if (!key_exists($key, $_GET))
            return "";
        else
            return $_GET[$key];
    }

    public function SESSION(string $key)
    {
        if (!key_exists($key, $_SESSION))
            return "";
        else
            return $_SESSION[$key];
    }

    public function POST(string $key)
    {
        if (!key_exists($key, $_POST))
            return "";
        else
            return $_POST[$key];
    }

    public function FILE(string $key)
    {
        if (!key_exists($key, $_FILES))
            return "";
        else
            return $_FILES[$key];
    }

    public function setSESSION(string $key, string $value)
    {
        $_SESSION[$key] = $value;
    }

}