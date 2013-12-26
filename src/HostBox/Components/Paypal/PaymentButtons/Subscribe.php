<?php

namespace HostBox\Components\PayPal\PaymentButtons;

/**
 * @identifier subscribe
 */
class Subscribe extends PaypalPaymentButton {

    const
        PERIOD_DAYS = 'D',
        PERIOD_WEEKS = 'W',
        PERIOD_MONTHS = 'M',
        PERIOD_YEARS = 'Y';

    /** @var int */
    public $recurrences;

    /** @var string */
    public $period = self::PERIOD_MONTHS;

}
