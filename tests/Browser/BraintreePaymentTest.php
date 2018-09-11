<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BraintreePaymentTest extends DuskTestCase
{
    /**
     * Successful Braintree Payment Test
     * Asserts if the checkout page contains the text Order Confirmation.
     * Assert if redirects to Order Confirmation page after payment processing.
     * Asserts if the Order confirmation page contains necessary text.
     *
     * @return void
     */
    /** @test */
    public function braintreePaymentTest()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Order Information')
                ->type('price','100')
                ->type('full_name','Sirish Shrestha')
                ->type('card_holder_name','Ashish Shrestha')
                ->waitFor('iframe[name=braintree-hosted-field-number]')
                ->waitFor('iframe[name=braintree-hosted-field-expirationDate]')
                ->waitFor('iframe[name=braintree-hosted-field-cvv]');

            $browser->driver->switchTo()->frame('braintree-hosted-field-number');
            $browser->keys('#credit-card-number', '4111111111111111');
            $browser->driver->switchTo()->defaultContent();

            $browser->driver->switchTo()->frame('braintree-hosted-field-expirationDate');
            $browser->keys('#expiration', '12/2019');
            $browser->driver->switchTo()->defaultContent();

            $browser->driver->switchTo()->frame('braintree-hosted-field-cvv');
            $browser->keys('#cvv', '123');
            $browser->driver->switchTo()->defaultContent();

            $browser->press('Submit')->pause(5000);
            $browser
                ->assertPathBeginsWith('/order-confirmation')//Assert that the URL (relative) path begins with given path.
                ->waitForText('Order Confirmed. Your order id is:');
        });
    }
}
