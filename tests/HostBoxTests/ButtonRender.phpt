<?php

namespace HostBoxTests;

use HostBox\Components\PayPal\PaymentButtons;
use HostBox\Components\PayPal\PaymentButtons\PaypalPaymentButton;
use Nette\Application\Request;
use Nette\Configurator;
use Tester;

require_once __DIR__ . '/bootstrap.php';


class ButtonRenderTest extends Tester\TestCase {

    /** @var PaymentButtons\ButtonFactory */
    private $factory;


    protected function setUp() {
        $this->factory = new PaymentButtons\ButtonFactory(new PaymentButtons\Config('12345'));
    }

    private function renderComponent(PaymentButtons\PaypalPaymentButton $component, $settings = array()) {
        ob_start();
        $component->render($settings);

        return ob_get_clean();
    }

    public function testDefaultSettings() {
        $this->connectButton($cart = $this->factory->createAddToCart());
        Tester\Assert::match(
            '<script src="/js/paypal-button-minicart.min.js?merchant=12345" data-button="cart" data-quantity="1" data-currency="CZK"></script>',
            $this->renderComponent($cart));

        $this->connectButton($buyNow = $this->factory->createBuyNow());
        Tester\Assert::match(
            '<script src="/js/paypal-button.min.js?merchant=12345" data-button="buynow" data-quantity="1" data-currency="CZK"></script>',
            $this->renderComponent($buyNow));

        $this->connectButton($donate = $this->factory->createDonate());
        Tester\Assert::match(
            '<script src="/js/paypal-button.min.js?merchant=12345" data-button="donate" data-quantity="1" data-currency="CZK"></script>',
            $this->renderComponent($donate));

        $this->connectButton($qr = $this->factory->createQRCodes());
        Tester\Assert::match(
            '<script src="/js/paypal-button.min.js?merchant=12345" data-button="qr" data-quantity="1" data-currency="CZK"></script>',
            $this->renderComponent($qr));

        $this->connectButton($subscribe = $this->factory->createSubscribe());
        Tester\Assert::match(
            '<script src="/js/paypal-button.min.js?merchant=12345" data-button="subscribe" data-period="M" data-currency="CZK"></script>',
            $this->renderComponent($subscribe));
    }

    public function testSettings() {
        $this->connectButton($buyNow = $this->factory->createBuyNow(array('quantity' => 10, 'itemNumber' => 1, 'tax' => 1.5)));
        Tester\Assert::match(
            '<script src="/js/paypal-button.min.js?merchant=12345" data-button="buynow" data-quantity="10" data-tax="1.5" data-item_number="1" data-currency="CZK"></script>',
            $this->renderComponent($buyNow));
    }

    public function testTemporarySettings() {
        $this->connectButton($buyNow = $this->factory->createBuyNow());
        Tester\Assert::match(
            '<script src="/js/paypal-button.min.js?merchant=12345" data-button="buynow" data-quantity="10" data-tax="1.5" data-item_number="1" data-currency="CZK"></script>',
            $this->renderComponent($buyNow, array('quantity' => 10, 'itemNumber' => 1, 'tax' => 1.5)));

        Tester\Assert::match(
            '<script src="/js/paypal-button.min.js?merchant=12345" data-button="buynow" data-quantity="1" data-currency="CZK"></script>',
            $this->renderComponent($buyNow));
    }

    /**
     * @param PaymentButtons\PaypalPaymentButton $button
     * @return MockPresenter
     * @throws \Nette\InvalidStateException
     * @throws \Nette\Application\UI\BadSignalException
     * @throws \Nette\UnexpectedValueException
     * @throws \Exception
     * @throws \Nette\InvalidArgumentException
     * @throws \Nette\Application\ForbiddenRequestException
     * @throws \Nette\Application\BadRequestException
     */
    protected function connectButton(PaymentButtons\PaypalPaymentButton $button) {
        $container = $this->createContainer();

        /** @var MockPresenter $presenter */
        $presenter = $container->createInstance('HostBoxTests\MockPresenter', array('button' => $button));
        $container->callInjects($presenter);
        $presenter->run(new Request('Mock', 'GET', array('action' => 'default'), array()));

        $presenter['button'];

        return $presenter;
    }

    /**
     * @return \SystemContainer
     * @throws \Nette\InvalidStateException
     */
    protected function createContainer() {
        $config = new Configurator();
        $config->setTempDirectory(TEMP_DIR);

        return $config->createContainer();
    }

}

class MockPresenter extends \Nette\Application\UI\Presenter {

    /** @var PaypalPaymentButton */
    private $button;


    public function __construct(PaypalPaymentButton $button) {
        $this->button = $button;
    }

    protected function beforeRender() {
        $this->terminate();
    }

    /**
     * @return PaypalPaymentButton
     */
    protected function createComponentButton() {
        return $this->button;
    }

}

\run(new ButtonRenderTest());
