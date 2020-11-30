<?php

namespace Tests;

use FormGenerator\FormTypeHandler;
use PHPUnit\Framework\TestCase;

class FormTypeHandlerTest extends TestCase
{
    public function testTypeDetection()
    {
        $handler = new FormTypeHandler();
        $this->assertSame('date', $handler->typeDetection('created_at'));
        $this->assertSame('email', $handler->typeDetection('email'));
    }
}
