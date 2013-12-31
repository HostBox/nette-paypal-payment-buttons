<?php

namespace HostBox\Components\PayPal\PaymentButtons;

use Nette\Application as Nette;


abstract class BasicButton extends PaypalPaymentButton {

    /** @var int */
    public $quantity = 1;

    /** @var float */
    public $shipping;

    /** @var float */
    public $tax;

    /**
     * @var string
     * @name cpp_logo_image
     */
    public $logoUrl;

    /** @var mixed */
    public $custom;

    /** @var int */
    public $itemNumber;

}
