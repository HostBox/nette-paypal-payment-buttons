<?php

namespace HostBox\Components\PayPal\PaymentButtons;

use Nette;


class Config extends Nette\Object {

    /** @var string */
    private $merchantId;

    /** @var string */
    private $sandbox;

    /** @var string */
    private $currency;


    /**
     * @param string $merchantId
     * @param bool $sandbox
     * @param string $currency
     */
    public function __construct($merchantId, $sandbox = FALSE, $currency = 'CZK') {
        $this->merchantId = $merchantId;
        $this->sandbox = $sandbox;
        $this->currency = $currency;
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
     * @param string $sandbox
     */
    public function setSandbox($sandbox) {
        $this->sandbox = $sandbox;
    }

    /**
     * @return string
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
