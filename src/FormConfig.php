<?php

namespace FormGenerator;

use FormGenerator\Exception\FormConfigException;

class FormConfig
{
    /**
     * @var mixed[]
     */
    private array $config = [
        'FULL_HTML_STRUCTURE'   => false,
        'TYPE_DETECTION'        => true,
        'EMPTY_GENERATED_FIELD' => true,
        'FORM_METHOD'           => 'POST',
        'FORM_CLASS'            => null,
        'FORM_ACTION'           => null,
        'FORM_SUBMIT_VALUE' => null,
        'FORM_SUBMIT' => false
    ];

    /**
     * FormConfig constructor.
     *
     * @param mixed[] $config
     */
    public function __construct(array $config = [])
    {
        foreach ($config as $key => $value) {
            $config[$key] = $value;
        }
    }

    /**
     * Define a value for the correspondant key.
     *
     * @param string $key   The key (no case sensitive)
     * @param bool|string   $value Value to assign to the key
     *
     * @throws FormConfigException Throw FormConfigException if the key not exists
     *
     * @return $this
     */
    public function set(string $key, $value): self
    {
        $this->checkKey(mb_strtoupper($key));
        $this->config[mb_strtoupper($key)] = $value;

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
        $this->checkKey($key);

        return $this->config[$key];
    }

    private function checkKey(string $key): void
    {
        if (!\array_key_exists($key, $this->config)) {
            throw new FormConfigException("The key \"$key\" is not a correct key, please see the documentation for all keys"); // phpcs:ignore
        }
    }
}
