<?php

namespace FormGenerator;

use FormGenerator\Exception\FormConfigException;

class FormConfig
{
    /**
     * @var bool[]
     */
    private array $config = [
        'FULL_HTML_STRUCTURE' => false,
        'TYPE_DETECTION'      => true
    ];

    /**
     * Define a value for the correspondant key.
     *
     * @param string $key   The key (no case sensitive)
     * @param bool   $value Value to assign to the key
     *
     * @throws FormConfigException Throw FormConfigException if the key not exists
     *
     * @return $this
     */
    public function set(string $key, bool $value): self
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
     */
    public function get(string $key): bool
    {
        $this->checkKey($key);

        return $this->config[$key];
    }

    private function checkKey(string $key): void
    {
        if (!isset($this->config[$key])) {
            throw new FormConfigException("The key '$key' is not a correct key, please see the documentation for all keys"); // phpcs:ignore
        }
    }
}
