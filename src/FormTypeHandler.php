<?php

namespace FormGenerator;

class FormTypeHandler
{
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

    /**
     * @param string $name Name of the field
     *
     * @return string Return the type of the field
     */
    public function typeDetection(string $name): string
    {
        if (\in_array($name, $this->types, true)) {
            return $name;
        }
        if (isset(explode('_', $name)[1]) && 'at' === explode('_', $name)[1]) {
            return 'date';
        }

        return 'text';
    }
}
