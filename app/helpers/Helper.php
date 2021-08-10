<?php

namespace App\Helpers;

class Helper {
    private const CODE_MAPPER = [
        '237' => [
            'country' => 'Cameroon',
            'regex' => "\(237\)\ ?[2368]\d{7,8}$"
        ],
        '251' => [
            'country' => 'Ethiopia',
            'regex' => "\(251\)\ ?[1-59]\d{8}$"
        ],
        '212' => [
            'country' => 'Morocco',
            'regex' => "\(212\)\ ?[5-9]\d{8}$"
        ],
        '258' => [
            'country' => 'Mozambique',
            'regex' => "\(258\)\ ?[28]\d{7,8}$"
        ],
        '256' => [
            'country' => 'Uganda',
            'regex' => "\(256\)\ ?\d{9}$"
        ]
    ];

    public static function getCodes() {
        return self::CODE_MAPPER;
    }

    public static function getCountryCodeOfPhone($phone) {
        if ($phone) {
            $phone = explode(' ', $phone);
            return str_replace(array('(',')'), '',$phone[0]);
        }

        return null;
    }

    public static function getCountryByCode($code) {
        return self::CODE_MAPPER[$code]['country'];
    }

    public static function checkCodeValidity($phone) {
        $code = self::getCountryCodeOfPhone($phone);
        return preg_match('/'.self::CODE_MAPPER[$code]['regex'].'/', $phone);
    }
}