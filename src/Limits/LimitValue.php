<?php
namespace NeuroBro\Contracts\Limits;

readonly class LimitValue
{
    public function __construct(
        private LimitLevel $level,
        private int $seconds,
        private int $remaining
    ) {}

    public function getLevel(): LimitLevel
    {
        return $this->level;
    }

    public function getSeconds(): int
    {
        return $this->seconds;
    }

    public function getRemaining(): int
    {
        return $this->remaining;
    }
}