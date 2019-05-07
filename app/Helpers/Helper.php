<?php

namespace App\Helpers;

class Helper
{
    public static function getRandomInt()
    {
      	return str_shuffle('0123456789');
    }
}