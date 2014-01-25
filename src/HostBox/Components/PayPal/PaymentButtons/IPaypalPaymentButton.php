<?php

namespace HostBox\Components\PayPal\PaymentButtons;


interface IPaypalPaymentButton {

    /**
     * @param array|null $settings
     * @return void
     */
    public function render($settings = array());

    /**
     * @param array $settings
     * @return void
     */
    public function assign(array $settings);

}
