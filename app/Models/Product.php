<?php

namespace Models;

class Product
{
    private $name;
    private $href;

    public function __construct(string $name, string $href)
    {
        $this->name = $name;
        $this->href = $href;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getHref(): ?string
    {
        return $this->href;
    }
}