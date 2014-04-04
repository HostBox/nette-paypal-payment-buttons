<?php

namespace HostBoxTests;

use HostBox\Components\PayPal\PaymentButtons;
use Tester;

require_once __DIR__ . '/bootstrap.php';


class ButtonSettingsTests extends Tester\TestCase {

    /** @var PaymentButtons\ButtonFactory */
    private $factory;

    /** @var PaymentButtons\Config */
    private $config;

    /** @var array */
    private $settings;


    public function setUp() {
        $this->config = new PaymentButtons\Config('unknown');
        $this->factory = new PaymentButtons\ButtonFactory($this->config);
        $this->settings = array(
            'name' => 'test',
            'amount' => 10.5
        );
    }

    public function testUpdateSettingsByFactoryAssign() {
        $plugin = $this->factory->createBuyNow($this->settings);

        Tester\Assert::same('test', $plugin->name);
        Tester\Assert::same(10.5, $plugin->amount);
    }

    public function testUpdateSettingsByPluginAssign() {
        $plugin = new PaymentButtons\Donate($this->config);
        $plugin->assign($this->settings);

        Tester\Assert::same('test', $plugin->name);
        Tester\Assert::same(10.5, $plugin->amount);
    }

    public function testUpdateSettingsByPluginProperty() {
        $plugin = new PaymentButtons\Subscribe($this->config);
        $plugin->period = PaymentButtons\Subscribe::PERIOD_YEARS;

        Tester\Assert::same(PaymentButtons\Subscribe::PERIOD_YEARS, $plugin->period);
    }

}

\run(new ButtonSettingsTests());
