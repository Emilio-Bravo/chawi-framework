<?php

namespace Core\Client;

class ViewHelper
{
    public function url($path)
    {
        return $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $path;
    }
}
