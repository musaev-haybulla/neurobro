<?php
namespace NeuroBro\Models\Base;

use NeuroBro\Contracts\AIModel;
use NeuroBro\Contracts\AINetwork;
use NeuroBro\Contracts\AIRequest;
use NeuroBro\Contracts\Price;
use NeuroBro\Contracts\Limits\LimitResponse;
use NeuroBro\Contracts\Limits\LimitLevel;
use NeuroBro\Contracts\Limits\LimitValue;
use Swoole\Atomic;

abstract class AbstractModel implements AIModel
{
    protected array $supportedFileTypes = [];
    /** @var array<string, Atomic> */
    private array $limitCounters = [];

    public function __construct(
        protected AINetwork $network,
        protected Price $inputPrice,
        protected Price $outputPrice
    ) {}

    public function getNetwork(): AINetwork
    {
        return $this->network;
    }

    public function getInputPrice(): Price
    {
        return $this->inputPrice;
    }

    public function getOutputPrice(): Price
    {
        return $this->outputPrice;
    }

    public function getSupportedFileTypes(): array
    {
        return $this->supportedFileTypes;
    }

    protected function getLimitCounter(string $key): Atomic
    {
        if (!isset($this->limitCounters[$key])) {
            $this->limitCounters[$key] = new Atomic(0);
        }
        return $this->limitCounters[$key];
    } 

    public function getCurrentLimits(string $apiKey): LimitResponse
    {
        // Каждая модель должна реализовать свою логику лимитов,
        // но базовая реализация может включать минутные и часовые лимиты
        $limits = [];

        // Пример с минутным лимитом
        $minuteCounter = $this->getLimitCounter("{$apiKey}:minute");
        $limits[] = new LimitValue(
            LimitLevel::MINUTE,
            60 - (time() % 60),
            $this->getMinuteLimit() - $minuteCounter->get()
        );

        // Пример с часовым лимитом
        $hourCounter = $this->getLimitCounter("{$apiKey}:hour");
        $limits[] = new LimitValue(
            LimitLevel::HOUR,
            3600 - (time() % 3600),
            $this->getHourLimit() - $hourCounter->get()
        );

        return new LimitResponse($limits);
    }

    // Эти методы должны быть переопределены в конкретных моделях
    abstract protected function getMinuteLimit(): int;
    abstract protected function getHourLimit(): int;

    abstract public function canProcess(AIRequest $request): bool;
    abstract public function process(AIRequest $request): array;
}