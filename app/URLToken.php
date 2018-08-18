<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class URLToken extends Model
{
    private $alphabet;

    public function __construct($alphabet)
    {
        // initialize alphabet
        $this->alphabet = $alphabet;
        $this->len = strlen($alphabet);
    }

    public function encode($int)
    {
        if (is_int($int))
        {
            // cast to str so it can be sequenced against alphabet
            $int = (string) $int;
        }

        if ($int == 0)
        {
            // this should thereoetically never happen because of the crc32 hash beforehand
            return $this->alphabet[0];
        }
        else
        {
            $prepStr = '';
            
            while ($int > 0)
            {
                $prepStr .=  $this->alphabet[($int % $this->len)];
                $int = floor($int / $this->len);
            }

            return strrev($prepStr);
        }
    }

    public function decode($str)
    {
        $defInt = 0;
        $len = strlen($str);

        for ($i = 0; $i < $len; $i++)
        {
            $chPos = strpos($this->alphabet, $str[$i]);
            $int = $defInt * ($this->len) + $chPos;
        }

        return $int;
    }
}