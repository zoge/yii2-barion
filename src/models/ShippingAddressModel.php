<?php

/**
 * Copyright 2016 Barion Payment Inc. All Rights Reserved.
 * <p/>
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * <p/>
 * http://www.apache.org/licenses/LICENSE-2.0
 * <p/>
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
class ShippingAddressModel implements iBarionModel
{
    public $DeliveryMethod;
    public $Country;
    public $Region;
    public $City;
    public $Zip;
    public $Street;
    public $Street2;
    public $Street3;
    public $FullName;
    public $Phone;

    function __construct()
    {
        $this->DeliveryMethod = "";
        $this->Country = "";
        $this->Region = "";
        $this->City = "";
        $this->Zip = "";
        $this->Street = "";
        $this->Street2 = "";
        $this->Street3 = "";
        $this->FullName = "";
        $this->Phone = "";
    }

    public function fromJson($json)
    {
        if (!empty($json)) {
            $this->DeliveryMethod = jget($json, 'DeliveryMethod');
            $this->Country = jget($json, 'Country');
            $this->Region = jget($json, 'Region');
            $this->City = jget($json, 'City');
            $this->Zip = jget($json, 'Zip');
            $this->Street = jget($json, 'Street');
            $this->Street2 = jget($json, 'Street2');
            $this->Street3 = jget($json, 'Street3');
            $this->FullName = jget($json, 'FullName');
            $this->Phone = jget($json, 'Phone');
        }
    }
}