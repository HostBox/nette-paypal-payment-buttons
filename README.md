Paypal Payment buttons for Nette Framework [![Build Status](https://travis-ci.org/HostBox/nette-paypal-payment-buttons.png)](https://travis-ci.org/HostBox/nette-paypal-payment-buttons)
===================


Support for Buy Now, Add to Cart, Donate, QR Codes, and Subscribe buttons
-------------------


Package Installation
-------------------

The best way to install Social Plugins is using [Composer](http://getcomposer.org/):

```sh
$ composer require hostbox/nette-paypal-payment-buttons
```

[Packagist - Versions](https://packagist.org/packages/hostbox/nette-paypal-payment-buttons)

[Nette Forum (cs) - plugin section](http://forum.nette.org/cs/16397-paypal-payment-buttons-jednoducha-komponent-pro-vytvareni-payment-tlacitek)

or manual edit composer.json in your project

```json
"require": {
    "hostbox/nette-paypal-payment-buttons": "dev-master"
}
```

Component Installation
-------------------

**config.neon**

    services:
        # Config
        - HostBox\Components\PayPal\PaymentButtons\Config('PaypalMerchantId')
        # Factory
        - HostBox\Components\PayPal\PaymentButtons\ButtonFactory


**Presenter**

```php
use HostBox\Components\PayPal\PaymentButtons\ButtonFactory;
use HostBox\Components\PayPal\PaymentButtons\Subscribe;
use Nette\Application\UI\Presenter;

class PaypalPaymentPresenter extends Presenter {

    /** @var ButtonFactory */
    protected $buttonFactory;


    public function __construct(ButtonFactory $buttonFactory) {
        $this->buttonFactory = $buttonFactory;
    }

    // component create by Factory
    public function createComponentBuyNow() {
        return $this->buttonFactory->createBuyNow();
    }

    // default settings by factory function parameter
    public function createComponentDonate() {
        return $this->buttonFactory->createDonate(array(
            'quantity' => 10,
            'tax' => 10.5
        ));
    }

    // by component function parameter
    public function createComponentQRCodes() {
        $component = $this->buttonFactory->createQRCodes();
        $component->assign(array(
            'quantity' => 10,
            'tax' => 10.5
        ));

        return $component;
    }

    // by component variable
    public function createComponentSubscribe() {
        $component = $this->buttonFactory->createSubscribe();
        $component->period = Subscribe::PERIOD_YEARS

        return $component;
    }

}
```

**Template**

    {control buyNow}
    {control addToCart}
    {control subscribe}
    {control qRCodes}

    // settings editing in Template
    {control donate, quantity => 10, tax => 10.5}

