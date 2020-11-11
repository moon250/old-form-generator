<?php

namespace Tests;

use FormGenerator\FormGenerator;
use FormGenerator\Types\SelectType;
use PHPUnit\Framework\TestCase;

class FormGeneratorTest extends TestCase
{
    private FormGenerator $form;

    public function setUp(): void
    {
        $this->form = new FormGenerator();
    }

    public function testAddSimpleField()
    {
        $this->form->add('name');
        $html = '<input type="text" id="field-name" name="name" value="">';

        $this->assertSame($html, $this->form->generate());
    }

    public function testAddMultipleFields()
    {
        $this->form
            ->add('username')
            ->add('name');
        $html = '<input type="text" id="field-username" name="username" value="">
<input type="text" id="field-name" name="name" value="">';
        $this->assertSame($html, $this->form->generate());
    }

    public function testAddFieldWithSpecifiedValue()
    {
        $this->form->add('test', 'email');
        $html = '<input type="email" id="field-test" name="test" value="">';
        $this->assertSame($html, $this->form->generate());
    }

    public function testAutoDetectionCreatedAtType()
    {
        $this->form->add('created_at');
        $html = '<input type="date" id="field-created_at" name="created_at" value="">';
        $this->assertSame($html, $this->form->generate());
    }

    public function testFieldWithCustomType()
    {
        $this->form->add('users', new SelectType(['jean', 'jane']));
        $html = <<<HTML
<select id="field-users" name="users"><option value="0">jean</option><option value="1">jane</option></select>
HTML;
        $this->assertSame($html, $this->form->generate());
    }
}
