<?php

namespace FormGenerator\Types;

class TextType implements FormTypeInterface
{
    private string $data;

    public function getType(): string
    {
        return 'text';
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data): FormTypeInterface
    {
        $this->data = $data;

        return $this;
    }
}
