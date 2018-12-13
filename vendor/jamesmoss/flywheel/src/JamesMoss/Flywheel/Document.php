<?php

namespace JamesMoss\Flywheel;

class Document
{
    public $id;

    public function __construct(array $data = array())
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
