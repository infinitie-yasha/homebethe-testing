<?php

namespace Ci3\libraries;

class Test
{
    public static function dies(){
        print_r("Test library call executed successfully");
        die;
        return "library call executed";
    }

}