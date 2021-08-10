<?php

namespace App\Helpers;

class Helper {
    private const CODE_MAPPER = [
        '237' => 'Cameroon',
        '251' => 'Ethiopia',
        '212' => 'Morocco',
        '258' => 'Mozambique',
        '256' => 'Uganda',
    ];

    public static function getCountryCodeOfPhone($phone) {
        if ($phone) {
            $phone = explode(' ', $phone);
            return str_replace(array('(',')'), '',$phone[0]);
        }

        return null;
    }

    public static function getCountryByCode($code) {
        return self::CODE_MAPPER[$code];
    }

    public static function checkCodeValidity($phone) {
        $code = self::getCountryCodeOfPhone($phone);
        $country = self::getCountryByCode($code);

        switch($country) {
            case 'Cameroon':
                return preg_match("/\(237\)\ ?[2368]\d{7,8}$/", $phone);
                break;
            case 'Ethiopia':
                return preg_match("/\(251\)\ ?[1-59]\d{8}$/", $phone);
                break;
            case 'Morocco':
                return preg_match("/\(212\)\ ?[5-9]\d{8}$/", $phone);
                break;
            case 'Mozambique':
                return preg_match("/\(258\)\ ?[28]\d{7,8}$/", $phone);
                break;
            case 'Uganda':
                return preg_match("/\(256\)\ ?\d{9}$/", $phone);
                break;
        }
    }
}