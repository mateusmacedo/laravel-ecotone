<?php

declare(strict_types=1);

namespace Module\Core\Infrastructure\Database\MongoDB;

trait Versionable
{
    protected $versionField = 'version';

    public function getVersion(): int
    {
        return $this->{$this->versionField};
    }

    public function setVersion($version)
    {
        $this->{$this->versionField} = $version;
    }

    public function incrementVersion()
    {
        ++$this->{$this->versionField};
    }

    public function isVersionValid($version)
    {
        return $version === $this->getVersion();
    }

    public function scopeWhereVersion($query, $version)
    {
        return $query->where($this->versionField, $version);
    }
}
