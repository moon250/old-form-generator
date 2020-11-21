<?php

namespace Tests;

use FormGenerator\Exception\FormConfigException;
use FormGenerator\FormConfig;
use PHPUnit\Framework\TestCase;

class FormConfigTest extends TestCase
{
    private FormConfig $config;

    protected function setUp(): void
    {
        $this->config = new FormConfig();
    }

    public function testGetConfigWithWrongKey()
    {
        $this->expectException(FormConfigException::class);
        $this->config->get('aezrazerz');
    }

    public function testSetConfigWithWrongKey()
    {
        $this->expectException(FormConfigException::class);
        $this->config->set('aezrazerz', false);
    }

    public function testGetConfigWithCorrectKey()
    {
        $this->assertTrue($this->config->get('type_detection'));
    }

    public function testSetConfigWithCorrectKey()
    {
        $this->config->set('type_detection', false);
        $this->assertFalse($this->config->get('type_detection'));
    }

    public function testSetConfigIsCaseInsensitive()
    {
        $this->config->set('TYPE_DETECTION', true);
        $this->assertTrue($this->config->get('type_detection'));
    }

    public function testPassArrayToConstructor()
    {
        $config = new FormConfig([
            'full_html_structure' => true
        ]);
        $this->assertTrue($config->get('full_html_structure'));
    }
}
