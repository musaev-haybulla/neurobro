<?php
namespace NeuroBro\Services;

use NeuroBro\Models\Base\LimitTracker;
use NeuroBro\Contracts\Limits\LimitLevel;
use Swoole\Timer;

class LimitResetService
{
    public function __construct(
        private LimitTracker $limitTracker
    ) {}

    public function startTimers(): void
    {
        // Сброс минутных лимитов
        Timer::tick(60 * 1000, function () {
            $this->resetLimits(LimitLevel::MINUTE);
        });

        // Сброс часовых лимитов
        Timer::tick(3600 * 1000, function () {
            $this->resetLimits(LimitLevel::HOUR);
        });

        // Сброс дневных лимитов
        Timer::tick(86400 * 1000, function () {
            $this->resetLimits(LimitLevel::DAY);
        });
    }

    private function resetLimits(LimitLevel $level): void
    {
        // Здесь будет логика сброса лимитов для всех ключей
        // Возможно, через Redis или другое хранилище
    }
}