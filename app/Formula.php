<?php


namespace App;


class Formula
{

    public function __construct()
    {
        //fetch lookup table into memory
    }

    public function calculate($from, $to, $previousPrice)
    {
        //temp calc
        return number_format(round($previousPrice*($to/$from), 2), 2);
    }
}
