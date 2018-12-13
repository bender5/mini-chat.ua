<?php

namespace JamesMoss\Flywheel;

class Repository
{
    protected $name;
    protected $path;
    protected $formatter;

    public function __construct($name, Config $config)
    {

        $this->name      = $name;
        $this->path      = $config->getPath() . DIRECTORY_SEPARATOR . $name;
        $this->formatter = $config->getOption('formatter');

        $this->validateName($this->name);

        if (!file_exists($this->path)) {
            mkdir($this->path);
            chmod($this->path, 0777);
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function query()
    {
        return new Query($this);
    }

    public function findAll()
    {
        $ext       = $this->formatter->getFileExtension();
        $files     = glob($this->path . DIRECTORY_SEPARATOR . '*.' . $ext);
        $documents = array();

        foreach ($files as $file) {
            $data = $this->formatter->decode(file_get_contents($file));
            if (null !== $data) {
                $documents[] = new Document((array) $data);
            }
        }

        return $documents;
    }

    protected function validateName($name)
    {
        if (!preg_match('/^[0-9A-Za-z\_\-]{1,63}$/', $name)) {
            throw new \Exception(sprintf('`%s` is not a valid repository name.', $name));
        }

        return true;
    }

    public function store(Document $document)
    {
        if (!isset($document->id)) {
            $document->id = $this->generateId();
        }

        $path    = $this->getPathForDocument($document->id);
        $data    = $this->formatter->encode((array) $document);

        return file_put_contents($path, $data);
    }

    public function delete($id)
    {
        $path = $this->getPathForDocument($id);

        return unlink($path);
    }

    public function getPathForDocument($id)
    {
        return $this->path . DIRECTORY_SEPARATOR . $this->getFilename($id);
    }

    public function getFilename($id)
    {
        return $id . '_' . sha1($id) . '.' . $this->formatter->getFileExtension();
    }

    protected function generateId()
    {
        static $choices = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $id = '';
        while (strlen($id) < 9) {
            $id .= $choices[ mt_rand(0, strlen($choices) - 1) ];
        }
        return $id;
    }

}
