<?php

namespace RelativeTime\Adapters;

abstract class Language implements \ArrayAccess
{
    protected $strings = array();

    public function offsetSet($id, $value) { $this->strings[$id] = $value; }

    public function offsetGet($id)
    {
        if (!array_key_exists($id, $this->strings))
            throw new \InvalidArgumentException($id . ' is not defined');

        return $this->strings[$id];
    }

    public function offsetExists($id) { return array_key_exists($id, $this->strings); }

    public function offsetUnset($id) { unset($this->strings[$id]); }

    public function keys() { return array_keys($this->strings); }
}

?>
