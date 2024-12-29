<?php
namespace NeuroBro\Models\Base;

use NeuroBro\Contracts\AINetwork;

abstract class AbstractNetwork implements AINetwork
{
    protected array $models = [];

    public function __construct(
        protected string $baseUrl
    ) {}

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getModels(): array
    {
        return $this->models;
    }

    public function addModel($model): void
    {
        $this->models[] = $model;
    }
}