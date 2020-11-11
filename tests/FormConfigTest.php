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
        $this->assertTrue($this->config->get('TYPE_DETECTION'));
    }

    public function testSetConfigWithCorrectKey()
    {
        $this->config->set('TYPE_DETECTION', false);
        $this->assertFalse($this->config->get('TYPE_DETECTION'));
    }

    public function testSetConfigIsCaseInsensitive()
    {
        $this->config->set('type_detection', true);
        $this->assertTrue($this->config->get('TYPE_DETECTION'));
    }
}
