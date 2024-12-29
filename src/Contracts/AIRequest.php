<?php
namespace NeuroBro\Contracts;

class AIRequest
{
    public function __construct(
        private string $prompt,
        private int $maxTokens,
        private float $temperature,
        private string $apiKey,
        private bool $isFreeUse = false,
        private ?array $attachments = null
    ) {}

    public function getPrompt(): string
    {
        return $this->prompt;
    }

    public function getMaxTokens(): int
    {
        return $this->maxTokens;
    }

    public function getTemperature(): float
    {
        return $this->temperature;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function isFreeUse(): bool
    {
        return $this->isFreeUse;
    }

    public function getAttachments(): ?array
    {
        return $this->attachments;
    }
}