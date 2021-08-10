<?php

namespace App\Models;

use App\Helpers\Helper;

class Customer extends Model {
    protected $table = 'customer';

    protected $appends = [
        'countryCode',
        'phoneNum',
        'country',
        'state'
    ];

    private const COUNTRY_REGEX_MAPPER = [
        'Cameroon' => 'Cameroon',
        'Ethiopia' => 'Ethiopia',
        'Morocco' => 'Morocco',
        'Mozambique' => 'Mozambique',
        'Uganda' => 'Uganda',
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
            return Helper::getCountryByCode($country_code);
        }
        
        return null;
    }

    public function getStateAttribute() {
        if ($this->phone) {
            $state = Helper::checkCodeValidity($this->phone);

            return $state ? 'OK' : 'NOK';
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