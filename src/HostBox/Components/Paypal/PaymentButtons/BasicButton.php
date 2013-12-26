<?php

namespace HostBox\Components\PayPal\PaymentButtons;

use Nette\Application as Nette;


abstract class BasicButton extends PaypalPaymentButton {

    /** @var int */
    public $quantity;

    /** @var float */
    public $shipping;

    /** @var float */
    public $tax;

}
