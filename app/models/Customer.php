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
        if (isset($data['valid'])) {
            if ($data['valid'] == 'valid') {
                foreach(Helper::getCodes() as $code) {
                    $this->orWhere('phone', 'REGEXP', $code['regex']);
                }
            } else if ($data['valid'] == 'invalid') {
                foreach(Helper::getCodes() as $code) {
                    $this->Where('phone', 'NOT REGEXP', $code['regex']);
                }
            }
        }

        return $this;
    }
}