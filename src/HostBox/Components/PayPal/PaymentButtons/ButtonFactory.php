<?php

namespace HostBox\Components\PayPal\PaymentButtons;

use HostBox\Components\PayPal\PaymentButtons\Exceptions\MemberAccessException;
use Nette;
use Nette\Reflection\ClassType;


/**
 * @method BuyNow createBuyNow(array $settings = array())
 * @method AddToCart createAddToCart(array $settings = array())
 * @method Donate createDonate(array $settings = array())
 * @method Subscribe createSubscribe(array $settings = array())
 * @method QRCodes createQRCodes(array $settings = array())
 */
class ButtonFactory extends Nette\Object {

    /** @var mixed */
    private $config;

    /** @var array */
    protected $plugins;


    public function __construct(Config $config) {
        $this->config = $config;
    }


    /**
     * @param string $name
     * @param array $args
     * @throws Exceptions\MemberAccessException
     * @return IPaypalPaymentButton|mixed
     */
    public function __call($name, $args) {
        if (substr($name, 0, 6) == 'create' && strlen($name) > 6) {
            $name = substr($name, -(strlen($name) - 6));

            $reflection = new ClassType(get_called_class());
            $componentName = $reflection->getNamespaceName() . '\\' . $name;
            if ($this->config === NULL) {
                throw new MemberAccessException('Config is not set');
            }
            /** @var IPaypalPaymentButton $component */
            $component = new $componentName($this->config);
            if (!empty($args) && is_array($settings = $args[0])) {
                $component->assign($settings);
            }

            return $component;
        } else {
            throw new MemberAccessException(sprintf('%s is not create method', $name));
        }
    }

}
