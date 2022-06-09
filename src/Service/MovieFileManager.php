<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MovieFileManager
{
    private $filesystem;
    private $directory;
    private $oldFile = null;

    public function __construct(string $movieDirectory, Filesystem $filesystem)
    {
        $this->directory = $movieDirectory;
        $this->filesystem = $filesystem;
    }

    public function setOldFile(string $oldFile): self
    {
        $this->oldFile = $oldFile;

        return $this;
    }

    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = transliterator_transliterate(
            'Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()',
            $originalFilename
        );

        $name = $safeFilename . '.' . $file->getClientOriginalExtension();
        $file->move($this->directory, $name);

        if( null != $this->oldFile ) {
            $this->removeFile();
        }

        return $name;
    }

    public function removeFile(): self
    {
        $path = $this->directory.$this->oldFile;
        if($this->filesystem->exists($path)) {
            $this->filesystem->remove($path);
        }

        return $this;
    }
}
