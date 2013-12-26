<?php

namespace HostBox\Components\PayPal\PaymentButtons;


interface IPaypalPaymentButton {

    /**
     * @param array|null $settings
     */
    public function render($settings = array());

    /**
     * @param array $settings
     */
    public function assign(array $settings);

}
