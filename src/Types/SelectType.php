<?php

namespace FormGenerator\Types;

class SelectType implements FormTypeInterface
{
    /**
     * @var string[]
     */
    private array $options;

    /**
     * SelectType constructor.
     *
     * @param string[] $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function getType(): string
    {
        return 'select';
    }

    public function getData(): string
    {
        $return = '';
        foreach ($this->options as $k => $option) {
            $return .= "\n    <option value=\"{$k}\">{$option}</option>";
        }

        return $return;
    }

    public function setData($data): FormTypeInterface
    {
        $this->options = $data;

        return $this;
    }
}
