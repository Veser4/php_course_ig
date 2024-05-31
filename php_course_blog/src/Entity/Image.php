<?php

namespace App\Entity;

class Image
{


    public function __construct(private ?int $id, private string $path)
    {

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $newPath)
    {
        $this->path = $newPath;
    }
}