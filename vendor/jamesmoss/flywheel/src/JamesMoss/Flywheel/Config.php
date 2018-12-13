<?php

namespace JamesMoss\Flywheel;

class Config
{
    protected $path;
    protected $options;

    public function __construct($path, array $options = array())
    {
        $path = rtrim($path, DIRECTORY_SEPARATOR);

        if (!is_dir($path)) {
            throw new \RuntimeException(sprintf('`%s` is not a directory.', $path));
        }

        if (!is_writable($path)) {
            throw new \RuntimeException(sprintf('`%s` is not writable.', $path));
        }

        $options = array_merge(array(
            'formatter' => new Formatter\Json,
        ), $options);

        $this->path    = $path;
        $this->options = $options;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getOption($name)
    {
        return isset($this->options[$name]) ? $this->options[$name] : null;
    }
}
