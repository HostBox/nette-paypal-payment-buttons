<?php

use HostBox\Components\PayPal\PaymentButtons;

require_once __DIR__ . '/bootstrap.php';


$factory = new PaymentButtons\ButtonFactory(
    $config = new PaymentButtons\Config('unknown')
);

$cases = array(
    array('HostBox\Components\PayPal\PaymentButtons\BuyNow', $factory->createBuyNow()),
    array('HostBox\Components\PayPal\PaymentButtons\AddToCart', $factory->createAddToCart()),
    array('HostBox\Components\PayPal\PaymentButtons\Donate', $factory->createDonate()),
    array('HostBox\Components\PayPal\PaymentButtons\Subscribe', $factory->createSubscribe()),
    array('HostBox\Components\PayPal\PaymentButtons\QRCodes', $factory->createQRCodes())
);

foreach ($cases as $case) {
    Tester\Assert::type($case[0], $case[1]);
}
