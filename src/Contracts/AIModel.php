<?php
namespace NeuroBro\Contracts;

use NeuroBro\Contracts\Limits\LimitResponse;

interface AIModel
{
    public function getName(): string;
    public function getNetwork(): AINetwork;

    // Лимиты
    public function getCurrentLimits(string $apiKey): LimitResponse;

    // Цены
    public function getInputPrice(): Price;
    public function getOutputPrice(): Price;

    // Возможности модели
    public function isSupportedAttachments(): bool;
    public function isSupportedImages(): bool;
    public function getSupportedFileTypes(): array;
    public function getMaxFileSize(): ?int;
    public function getMaxTokens(): int;

    // Обработка запросов
    public function canProcess(AIRequest $request): bool;
    public function process(AIRequest $request): array;
}