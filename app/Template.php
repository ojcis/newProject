<?php

namespace App;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Template
{
    private string $path;
    private array $data;
    private string $viewsBasePath = "../views";

    public function __construct(string $path, array $data = [])
    {
        $this->path = $path;
        $this->data = $data;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
