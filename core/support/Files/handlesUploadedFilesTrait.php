<?php

namespace Core\Support\Files;

trait handlesUploadedFiles
{
    public function imageUploadProccess(string $path, ...$keys): void
    {
        if ($this->hasFiles()) {
            foreach ($keys as $files_key) {
                $filename = \Core\Support\Crypto::cryptoImage($this, $files_key);
                $this->uploadIfIsImage($files_key, $path, $filename);
                $this->setInputValue($files_key, $filename);
            }
        }
    }

    public function imageUpdateProccess(string $path, array $keys, array $delete_filenames): void
    {
        if ($this->hasFiles()) {
            array_map(fn ($filename) => $this->deleteFile($path, $filename), $delete_filenames);
            foreach ($keys as $files_key) {
                $filename = \Core\Support\Crypto::cryptoImage($this, $files_key);
                $this->uploadIfIsImage($files_key, $path, $filename);
                $this->setInputValue($files_key, $filename);
            }
        }
    }
}