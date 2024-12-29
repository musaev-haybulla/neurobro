<?php
namespace NeuroBro\Models\Claude\Models;

use NeuroBro\Models\Base\AbstractModel;
use NeuroBro\Contracts\AIRequest;
use NeuroBro\Contracts\AINetwork;
use NeuroBro\Contracts\Price;
use NeuroBro\Contracts\Limits\LimitLevel;
use NeuroBro\Contracts\Limits\LimitValue;
use NeuroBro\Contracts\Limits\LimitResponse;

class ClaudeHaikuModel extends AbstractModel
{
    protected array $supportedFileTypes = [
        'text/plain',
        'text/markdown',
        'application/pdf',
        'image/jpeg',
        'image/png'
    ];

    public function __construct(
        AINetwork $network,
        Price $inputPrice,
        Price $outputPrice,
        private int $minuteLimit = 2,
        private int $hourLimit = 120
    ) {
        parent::__construct($network, $inputPrice, $outputPrice);
    }

    public function getName(): string
    {
        return 'haiku';
    }

    public function isSupportedAttachments(): bool
    {
        return true;
    }

    public function isSupportedImages(): bool
    {
        return true;
    }

    public function getMaxFileSize(): ?int
    {
        return 10 * 1024 * 1024; // 10MB
    }

    public function getMaxTokens(): int
    {
        return 128000;
    }

    protected function getMinuteLimit(): int
    {
        return $this->minuteLimit;
    }

    protected function getHourLimit(): int
    {
        return $this->hourLimit;
    }

    public function canProcess(AIRequest $request): bool
    {
        // Проверяем размер файлов
        if ($request->getAttachments()) {
            foreach ($request->getAttachments() as $attachment) {
                if ($attachment['size'] > $this->getMaxFileSize()) {
                    return false;
                }
                if (!in_array($attachment['type'], $this->getSupportedFileTypes())) {
                    return false;
                }
            }
        }

        // Проверяем лимит токенов
        if ($request->getMaxTokens() > $this->getMaxTokens()) {
            return false;
        }

        return true;
    }

    public function process(AIRequest $request): array
    {
        // Здесь будет реализация запроса к API Claude
        // Возвращает результат в стандартизированном формате
        return [];
    }
}