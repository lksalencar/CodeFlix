<?php

namespace CodeFlix\Media;
use Illuminate\Filesystem\FilesystemAdapter;

/**
 * @package \CodeFlix\Media
 */
trait VideoStorages
{
    /**
     * @return \Illuminate\Filesystem\FilesystemAdapter
     */
    public function getStorage()
    {
       return \Storage::disk($this->getDiskDriver());
    }
    protected function getDiskDriver()
    {//driver
       return config('filesystems.default');
    }
    protected function getAbsolutePath(FilesystemAdapter $storage, $fileRelativePath)
    {
       return $this->isLocalDriver() ?
           $storage->getDriver()->getAdapter()->applyPathPrefix($fileRelativePath) :
           $storage->url($fileRelativePath);
    }

    public function isLocalDriver()
    {
        $driver = config("filesystems.disks.{$this->getDiskDriver()}.driver");
        return $driver == 'local';
    }
}
