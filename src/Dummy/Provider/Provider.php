<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2023.
 *
 * Use of this software is governed by the Business Source License included in the LICENSE file and at https://getparthenon.com/docs/next/license.
 *
 * Change Date: TBD ( 3 years after 2.2.0 release )
 *
 * On the date above, in accordance with the Business Source License, use of this software will be governed by the open source license specified in the LICENSE file.
 */

namespace App\Dummy\Provider;

use Obol\ChargeBackServiceInterface;
use Obol\CreditServiceInterface;
use Obol\CustomerServiceInterface;
use Obol\HostedCheckoutServiceInterface;
use Obol\InvoiceServiceInterface;
use Obol\PaymentMethodServiceInterface;
use Obol\PaymentServiceInterface;
use Obol\PriceServiceInterface;
use Obol\ProductServiceInterface;
use Obol\Provider\ProviderInterface;
use Obol\RefundServiceInterface;
use Obol\SubscriptionServiceInterface;
use Obol\VoucherServiceInterface;
use Obol\WebhookServiceInterface;

class Provider implements ProviderInterface
{
    public function payments(): PaymentServiceInterface
    {
        return new PaymentService();
    }

    public function hostedCheckouts(): HostedCheckoutServiceInterface
    {
        return new HostedCheckoutService();
    }

    public function customers(): CustomerServiceInterface
    {
        return new CustomerService();
    }

    public function prices(): PriceServiceInterface
    {
        return new PriceService();
    }

    public function products(): ProductServiceInterface
    {
        return new ProductService();
    }

    public function refunds(): RefundServiceInterface
    {
        return new RefundService();
    }

    public function getName(): string
    {
        return 'test_dummy';
    }

    public function subscriptions(): SubscriptionServiceInterface
    {
        return new SubscriptionService();
    }

    public function webhook(): WebhookServiceInterface
    {
        return new WebhookService();
    }

    public function invoices(): InvoiceServiceInterface
    {
        return new InvoiceService();
    }

    public function chargeBacks(): ChargeBackServiceInterface
    {
        return new ChargeBackService();
    }

    public function paymentMethods(): PaymentMethodServiceInterface
    {
        // TODO: Implement paymentMethods() method.
    }

    public function credit(): CreditServiceInterface
    {
        // TODO: Implement credit() method.
    }

    public function vouchers(): VoucherServiceInterface
    {
        // TODO: Implement vouchers() method.
    }
}
