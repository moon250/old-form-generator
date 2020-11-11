<?php

namespace FormGenerator;

use FormGenerator\Types\FormTypeInterface;
use function count;
use function in_array;
use function is_object;

class FormGenerator
{
    /**
     * @var array[]
     */
    private array $fields;

    /**
     * @var string[]
     */
    private array $types = [
        'button',
        'checkbox',
        'color',
        'date',
        'datetime-local',
        'email',
        'file',
        'hidden',
        'image',
        'month',
        'number',
        'password',
        'radio',
        'range',
        'reset',
        'search',
        'submit',
        'tel',
        'text',
        'time',
        'url',
        'week'
    ];

    private FormConfig $config;

    public function __construct(?FormConfig $config = null)
    {
        $this->config = null !== $config ? $config : new FormConfig();
    }

    /**
     * Add a field to the form.
     *
     * @param string                        $name Name of the field
     * @param string|FormTypeInterface|null $type Type of the field (default is text)
     *
     * @return FormGenerator
     */
    public function add(string $name, $type = null): self
    {
        $type = isset($type) ? $type : $this->getType($name);
        $field = [
            'name'  => $name,
            'id'    => "field-{$name}",
            'value' => '',
            'type'  => $type
        ];
        if (is_object($type)) {
            $field['type'] = $type->getType();
            if ('select' === $field['type']) {
                $field['options'] = $type->getData();
            }
        }
        $this->fields[] = $field;

        return $this;
    }

    /**
     * Generate the form.
     */
    public function generate(): string
    {
        $form = '';
        foreach ($this->fields as $key => $field) {
            if ('select' === $field['type']) {
                $form = $form . $this->select($field);
            } else {
                $form = $form . $this->input($field);
            }
            if (($key + 1) < count($this->fields)) {
                $form .= "\n";
            }
        }
        $this->fields = [];

        return $form;
    }

    /**
     * Generate a select with correct parameters and options given in parameters.
     *
     * @param string[] $field Arrays contains parameters and options
     */
    private function select(array $field): string
    {
        return <<<HTML
<select id="{$field['id']}" name="{$field['name']}">{$field['options']}</select>
HTML;
    }

    /**
     * Generate an input with parameters given in parameters.
     *
     * @param string[] $field Arrays contains parameters
     */
    private function input(array $field): string
    {
        return str_replace("\n", '', "<input 
type=\"{$field['type']}\" 
id=\"{$field['id']}\" 
name=\"{$field['name']}\" 
value=\"{$field['value']}\">");
    }

    /**
     * Return type of the input, based on the name.
     *
     * @param string $name Name of the input
     */
    private function getType(string $name): string
    {
        if (true === $this->config->get('TYPE_DETECTION')) {
            if (in_array($name, $this->types, true)) {
                return $name;
            }
            if (isset(explode('_', $name)[1]) && 'at' === explode('_', $name)[1]) {
                return 'date';
            }
        }

        return 'text';
    }
}
