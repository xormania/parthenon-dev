<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the Business Source License included in the LICENSE file and at https://getparthenon.com/docs/next/license.
 *
 * Change Date: TBD ( 3 years after 2.2.0 release )
 *
 * On the date above, in accordance with the Business Source License, use of this software will be governed by the open source license specified in the LICENSE file.
 */

namespace Tests\Obol\Provider\Stripe\DataMapper;

use Obol\Models\Address;
use Obol\Models\Customer;
use Obol\Models\Enum\CustomerType;
use Obol\Provider\Stripe\DataMapper\CustomerMapper;
use PHPUnit\Framework\TestCase;

class CustomerMapperTest extends TestCase
{
    public const STREETLINEONE = '1 Example Lane';
    public const STREETLINETWO = 'Second Line';
    public const CITY = 'Example';
    public const COUNTRY = 'US';
    public const EMAIL = 'iain.cambridge@example.org';
    public const PHONE = '+44 1505 4033033';
    public const STATE = 'Example State';
    public const POSTALCODE = '10458';
    public const NAME = 'Iain Cambridge';

    public function testMapCustomer()
    {
        $address = new Address();
        $address->setStreetLineOne(self::STREETLINEONE)
            ->setStreetLineTwo(self::STREETLINETWO)
            ->setCity(self::CITY)
            ->setState(self::STATE)
            ->setCountryCode(self::COUNTRY)
            ->setPostalCode(self::POSTALCODE);

        $customer = new Customer();

        $customer
            ->setName(self::NAME)
            ->setEmail(self::EMAIL)
            ->setType(CustomerType::SOLE_TRADER)
            ->setPhone(self::PHONE)
            ->setAddress($address)
            ->setDescription('A test customer');

        $subject = new CustomerMapper();

        $result = $subject->mapCustomer($customer);

        $this->assertEquals(self::EMAIL, $result['email']);
        $this->assertEquals(self::PHONE, $result['phone']);
        $this->assertEquals(self::NAME, $result['name']);
        $this->assertEquals('A test customer', $result['description']);
        $this->assertEquals(self::STREETLINEONE, $result['address']['line1']);
        $this->assertEquals(self::STREETLINETWO, $result['address']['line2']);
        $this->assertEquals(self::CITY, $result['address']['city']);
        $this->assertEquals(self::STATE, $result['address']['state']);
        $this->assertEquals(self::COUNTRY, $result['address']['country']);
        $this->assertEquals(self::POSTALCODE, $result['address']['postal_code']);
    }
}
