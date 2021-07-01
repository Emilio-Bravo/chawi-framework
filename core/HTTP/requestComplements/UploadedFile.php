<?php

namespace Core\Http\RequestComplements;

class UploadedFile
{
    private object|bool $currentFile;

    private array $dangerousFilenameChars = [
        ' ', '"', "'",
        '&', '/', '\\',
        '?', '¿', '#',
        '<', '>', '$',
        '+', '%', '!',
        '`', '*', '|',
        '=', ':', '@',
        '{', '}', ';',
        ',', '[', ']'
    ];

    public function __construct(string $key)
    {
        $this->setCurrentFile($key);
        return $this;
    }

    public function tmpName(): string
    {
        return $this->currentFile->tmp_name;
    }

    public function name(): string
    {
        return str_replace($this->dangerousFilenameChars, '_', $this->currentFile->name);
    }

    public function getContents(): string
    {
        return file_get_contents($this->tmpName());
    }

    public function size(): string
    {
        return $this->currentFile->size;
    }

    public function type(): string
    {
        return $this->currentFile->type;
    }

    public function currentFile(): object
    {
        return $this->currentFile;
    }

    public function hasContents(): bool
    {
        return !is_bool($this->currentFile) && $this->currentFile->type != null;
    }

    private function setCurrentFile(string $key): object|false
    {
        if (key_exists($key, $_FILES)) {
            return $this->currentFile = (object) $_FILES[$key];
        }
        return $this->currentFile = false;
    }
}
