<?php

namespace HostBox\Components\PayPal\PaymentButtons;

use Nette;


class Config extends Nette\Object {

    /** @var string */
    private $merchantId;

    /** @var bool */
    private $sandbox;

    /** @var string */
    private $currency;


    /**
     * @param string $merchantId
     * @param string $currency
     * @param bool $sandbox
     */
    public function __construct($merchantId, $currency = 'CZK', $sandbox = FALSE) {
        $this->merchantId = $merchantId;
        $this->currency = $currency;
        $this->sandbox = $sandbox;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency) {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getCurrency() {
        return $this->currency;
    }

    /**
     * @param bool $sandbox
     */
    public function setSandbox($sandbox) {
        $this->sandbox = $sandbox;
    }

    /**
     * @return bool
     */
    public function getSandbox() {
        return $this->sandbox;
    }

    /**
     * @param string $merchantId
     */
    public function setMerchantId($merchantId) {
        $this->merchantId = $merchantId;
    }

    /**
     * @return string
     */
    public function getMerchantId() {
        return $this->merchantId;
    }

}
