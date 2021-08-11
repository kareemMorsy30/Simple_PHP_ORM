<?php

namespace App\Models;

use App\Helpers\Helper;

class Customer extends Model {
    // Define model class table name
    protected $table = 'customer';

    // Add the appended fields
    protected $appends = [
        'countryCode',
        'phoneNum',
        'country',
        'state'
    ];

    /**
     * Accessor to get country code
     * @return mixed
     */
    protected function getCountryCodeAttribute() {
        if ($this->phone) {
            return '+'.Helper::getCountryCodeOfPhone($this->phone);
        }
        
        return null;
    }

    /**
     * Accessor to get phone number
     * @return mixed
     */
    protected function getPhoneNumAttribute() {
        if ($this->phone) {
            $phone = explode(' ', $this->phone);
            return $phone[1];
        }
        
        return null;
    }

    /**
     * Accessor to get Country name
     * @return mixed
     */
    protected function getCountryAttribute() {
        if ($this->phone) {
            $country_code = Helper::getCountryCodeOfPhone($this->phone);
            return Helper::getCountryByCode($country_code);
        }
        
        return null;
    }

    /**
     * Accessor to get phone state
     * @return mixed
     */
    public function getStateAttribute() {
        if ($this->phone) {
            $state = Helper::checkCodeValidity($this->phone);

            return $state ? 'OK' : 'NOK';
        }
        
        return null;
    }

    /**
     * Filter data returned by the model based on the passed array
     * @return object
     */
    public function filter($data) {
        // If country code is present and not null
        if (isset($data['country']) && $data['country']) {
            // Get records that have phone numbers that are like the passed code
            $this->where('phone', 'LIKE', '%('.$data['country'].')%');
        }
        // If valid query parameter is present
        if (isset($data['valid'])) {
            if ($data['valid'] == 'valid') {
                // Loop on codes regex and query all the phone numbers that match
                foreach(Helper::getCodes() as $code) {
                    $this->orWhere('phone', 'REGEXP', $code['regex']);
                }
            } else if ($data['valid'] == 'invalid') {
                // Loop on codes regex and query all the phone numbers that not match
                foreach(Helper::getCodes() as $code) {
                    $this->Where('phone', 'NOT REGEXP', $code['regex']);
                }
            }
        }

        return $this;
    }
}