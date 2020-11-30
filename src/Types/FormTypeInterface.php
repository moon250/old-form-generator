<?php

namespace FormGenerator\Types;

interface FormTypeInterface
{
    public function getType(): string;

    /**
     * @return mixed
     */
    public function getData();

    /**
     * @param mixed $data
     */
    public function setData($data): self;
}
