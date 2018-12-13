<?php

namespace JamesMoss\Flywheel;

class Result implements \IteratorAggregate, \ArrayAccess, \Countable
{
    protected $documents;
    protected $total;

    public function __construct($documents, $total)
    {
        $this->documents = $documents;
        $this->total     = $total;
    }

    public function count()
    {
        return count($this->documents);
    }

    public function total()
    {
        return $this->total;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->documents);
    }

    public function offsetSet($offset, $value)
    {
        throw new \Exception('Cannot set values on Flywheel\Result');
    }

    public function offsetExists($offset)
    {
        return isset($this->documents[$offset]);
    }

    public function offsetUnset($offset)
    {
        throw new \Exception('Cannot unset values on Flywheel\Result');
    }

    public function offsetGet($offset)
    {
        return isset($this->documents[$offset]) ? $this->documents[$offset] : null;
    }

    public function first()
    {
        return !empty($this->documents) ? $this->documents[0] : false;
    }

    public function last()
    {
        return !empty($this->documents) ? $this->documents[count($this->documents) - 1] : false;
    }

    public function value($key)
    {
        $first = $this->first();

        if (!$first) {
            return false;
        }

        return isset($first->{$key}) ? $first->{$key} : false;
    }

    public function pick($field)
    {
        $result = array();

        foreach ($this->documents as $document) {
            if (isset($document->{$field})) {
                $result[] = $document->{$field};
            }
        }

        return $result;
    }

    public function hash($keyField, $valueField)
    {
        $result = array();

        foreach ($this->documents as $document) {
            $result[$document->{$keyField}] = $document->{$valueField};
        }

        return $result;
    }
}
