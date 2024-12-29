<?php
namespace NeuroBro\Contracts;

interface AINetwork
{
    public function getName(): string;
    public function getBaseUrl(): string;
    public function getModels(): array;
}