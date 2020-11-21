<?php

namespace FormGenerator;

use FormGenerator\Exception\FormConfigException;

class FormConfig
{
    /**
     * @var mixed[]
     */
    private array $config = [
        'empty_generated_field' => true,
        'form_action'           => null,
        'form_class'            => null,
        'form_id'               => null,
        'form_method'           => 'POST',
        'form_submit'           => true,
        'form_submit_value'     => null,
        'full_html_structure'   => false,
        'type_detection'        => true
    ];

    /**
     * FormConfig constructor.
     *
     * @param mixed[] $config
     */
    public function __construct(array $config = [])
    {
        foreach ($config as $key => $value) {
            $this->config[$key] = $value;
        }
    }

    /**
     * Define a value for the correspondant key.
     *
     * @param string      $key   The key (no case sensitive)
     * @param bool|string $value Value to assign to the key
     *
     * @throws FormConfigException Throw FormConfigException if the key not exists
     *
     * @return $this
     */
    public function set(string $key, $value): self
    {
        $this->checkKey(mb_strtolower($key));
        $this->config[mb_strtolower($key)] = $value;

        return $this;
    }

    /**
     * Return the value of the key.
     *
     * @param string $key Key to search in the config
     *
     * @throws FormConfigException Throw FormConfigException if the key not exists
     *
     * @return mixed
     */
    public function get(string $key)
    {
        $this->checkKey(mb_strtolower($key));

        return $this->config[mb_strtolower($key)];
    }

    private function checkKey(string $key): void
    {
        if (!\array_key_exists($key, $this->config)) {
            throw new FormConfigException("The key \"$key\" is not a correct key, please see the documentation for all keys"); // phpcs:ignore
        }
    }
}
