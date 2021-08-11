<?php

namespace App\Helpers;

class Helper {
    // Map country codes to countries and its REGEX
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

    /** 
     * Code mapper getter 
     * @return array
     */
    public static function getCodes() {
        return self::CODE_MAPPER;
    }

    /**
     * get country code from a phone number
     * @return mixed
     */
    public static function getCountryCodeOfPhone($phone) {
        if ($phone) {
            $phone = explode(' ', $phone);      // Convert phone string to array with a space as a delimiter
            return str_replace(array('(',')'), '',$phone[0]);       // Return the first element as the code after removing the parentheses
        }

        return null;
    }

    /**
     * get countries name by code
     * @return array
     */
    public static function getCountryByCode($code) {
        return self::CODE_MAPPER[$code]['country'];
    }

    /**
     * Check the validity of a phone number
     * @return int
     */
    public static function checkCodeValidity($phone) {
        $code = self::getCountryCodeOfPhone($phone);        // Get the code of the country from the phone
        return preg_match('/'.self::CODE_MAPPER[$code]['regex'].'/', $phone);       // Then get its REGEX from code mapper to check its validity against the REGEX
    }
}