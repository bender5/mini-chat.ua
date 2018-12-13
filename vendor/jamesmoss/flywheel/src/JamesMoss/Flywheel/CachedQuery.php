<?php

namespace JamesMoss\Flywheel;

class CachedQuery extends Query
{
    public function execute()
    {

        $key = $this->getParameterHash() . $this->getFileHash();

        $result = apc_fetch($key, $success);

        if (!$success) {
            $result = parent::execute();
            apc_store($key, $result);
        }

        return $result;
    }

    protected function getFileHash()
    {
        $path  = $this->repo->getPath();
        $files = scandir($path);
        $hash  = '';

        foreach ($files as $file) {
            if ($file == '..' || $file == '.') {
                continue;
            }

            $hash.= $file . '|';
            $hash.= (string) filemtime($path . '/' . $file) . '|';
        }

        $hash = md5($hash);

        return $hash;
    }

    protected function getParameterHash()
    {
        $parts = array(
            $this->repo->getName(),
            serialize((array) $this->limit),
            serialize((array) $this->orderBy),
            serialize((array) $this->where),
        );

        return md5(implode('|', $parts));
    }
}
