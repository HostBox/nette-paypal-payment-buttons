<?php

namespace HostBox\Components\PayPal\PaymentButtons;

use HostBox\Components\PayPal\PaymentButtons\Exceptions\MemberAccessException;
use Nette\Application as Nette;


abstract class PaypalPaymentButton extends Nette\UI\Control implements IPaypalPaymentButton {

    /** @var mixed */
    private $config;

    /** @var string */
    public $name;

    /** @var int */
    public $amount;


    public function __construct(Config $config) {
        $this->config = $config;
    }

    /**
     * @param array|null $settings
     */
    public function render($settings = array()) {
        $this->updateSettings($settings);
        $this->putSettingsIntoTemplate();

        $this->template->config = $this->config;
        $this->template->setFile(sprintf('%s/templates/default.latte', __DIR__));
        $this->template->render();
    }

    /**
     * @param array $settings
     */
    public function assign(array $settings) {
        $this->updateSettings($settings);
    }

    /**
     * @throws MemberAccessException
     */
    protected function putSettingsIntoTemplate() {
        $properties = $this->getReflection()->getProperties(\ReflectionProperty::IS_PUBLIC);
        if (count($properties) > 0) {
            $result = array();

            foreach ($properties as $property) {
                if ($property->getDeclaringClass() == 'Nette\Application\UI\Control') {
                    break;
                }

                if (($value = $this->{$property->name}) !== NULL) {
                    if (($name = $property->getAnnotation('name')) === NULL) {
                        $name = preg_replace('#(.)(?=[A-Z])#', '$1-', $property->name);
                        $name = strtolower($name);
                        $name = rawurlencode($name);
                    }

                    if (is_bool($value) === TRUE) {
                        $value = ($value ? 'true' : 'false');
                    }

                    $result[] = sprintf('data-%s="%s"', $name, $value);
                }
            }
            $this->template->pluginSettings = implode(' ', $result);
        }

        $reflection = $this->getReflection();
        $identifier = $reflection->getAnnotation('identifier');
        if ($identifier === NULL) {
            throw new MemberAccessException(sprintf('Class %s has not "identifier" annotation', $reflection->getShortName()));
        }
        $this->template->identifier = $identifier;
        $this->template->src = ($reflection->getShortName() == 'AddToCart' ? 'paypal-button-minicart.min.js' : 'paypal-button.min.js');
    }

    /**
     * @param array $settings
     */
    private function updateSettings(array $settings) {
        if (!is_array($settings) || empty($settings))
            return;

        $properties = $this->getReflection()->getProperties(\ReflectionProperty::IS_PUBLIC);
        if (count($properties) > 0) {
            foreach ($properties as $property) {
                if ($property->getDeclaringClass() == 'Nette\Application\UI\Control') {
                    break;
                }

                $propertyName = $property->name;
                if (array_key_exists($propertyName, $settings)) {
                    $this->$propertyName = $settings[$property->name];
                }
            }
        }
    }

}
