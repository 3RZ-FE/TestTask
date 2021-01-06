<?php

namespace Models;

class Record
{
    private $href;
    private $title;
    private $body;
    private $description;
    private $product;
    private $views;
    private $time_create;

    public function __construct(string $href,
                                string $title,
                                string $body,
                                string $description,
                                string $product,
                                int $views,
                                int $time_create)
    {
        $this->href = $href;
        $this->title = $title;
        $this->body = $body;
        $this->description = $description;
        $this->product = $product;
        $this->views = $views;
        $this->time_create = $time_create;
    }

    public function getHref(): ?string
    {
        return $this->href;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): ?string
    {
        $this->title = $title;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): ?string
    {
        $this->body = $body;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): ?string
    {
        $this->description = $description;
    }

    public function getProduct(): ?string
    {
        return $this->product;
    }

    public function setProduct(string $product): ?string
    {
        $this->product = $product;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(int $views): ?int
    {
        $this->views = $views;
    }

    public function getTimeCreate(): ?int
    {
        return $this->time_create;
    }

    public function setTimeCreate(int $time_create): ?int
    {
        $this->time_create = $time_create;
    }
}