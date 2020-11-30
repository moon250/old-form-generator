<?php

namespace FormGenerator\Types;

class DateTimeType implements FormTypeInterface
{
    /**
     * @var mixed
     */
    private $data;

    public function getType(): string
    {
        return 'date';
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
