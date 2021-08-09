<?php

namespace App\Helpers;

class Helper {
    public static function getCountryCodeOfPhone($phone) {
        if ($phone) {
            $phone = explode(' ', $phone);
            return str_replace(array('(',')'), '',$phone[0]);
        }

        return null;
    }
}