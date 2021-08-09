<?php

namespace App\Models;

use App\Helpers\Helper;

class Customer extends Model {
    protected $table = 'customer';

    protected $appends = [
        'countryCode',
        'phoneNum',
        'country'
    ];

    private const CODE_MAPPER = [
        '237' => 'Cameroon',
        '251' => 'Ethiopia',
        '212' => 'Morocco',
        '258' => 'Mozambique',
        '256' => 'Uganda',
    ];

    protected function getCountryCodeAttribute() {
        if ($this->phone) {
            return '+'.Helper::getCountryCodeOfPhone($this->phone);
        }
        
        return null;
    }

    protected function getPhoneNumAttribute() {
        if ($this->phone) {
            $phone = explode(' ', $this->phone);
            return $phone[1];
        }
        
        return null;
    }

    protected function getCountryAttribute() {
        if ($this->phone) {
            $country_code = Helper::getCountryCodeOfPhone($this->phone);
            return self::CODE_MAPPER[$country_code];
        }
        
        return null;
    }

    public function filter($data) {
        if (isset($data['country']) && $data['country']) {
            $this->where('phone', 'LIKE', '%('.$data['country'].')%');
        }

        return $this;
    }
}