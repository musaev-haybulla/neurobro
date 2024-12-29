<?php
namespace NeuroBro\Models\Base;

use Swoole\Atomic;
use NeuroBro\Contracts\Limits\LimitLevel;

class LimitTracker
{
    /** @var array<string, array<LimitLevel, Atomic>> */
    private array $counters = [];

    public function increment(string $apiKey, LimitLevel $level): void
    {
        $counter = $this->getCounter($apiKey, $level);
        $counter->add(1);
    }

    public function get(string $apiKey, LimitLevel $level): int
    {
        $counter = $this->getCounter($apiKey, $level);
        return $counter->get();
    }

    public function reset(string $apiKey, LimitLevel $level): void
    {
        $counter = $this->getCounter($apiKey, $level);
        $counter->set(0);
    }

    private function getCounter(string $apiKey, LimitLevel $level): Atomic
    {
        $key = $apiKey;
        if (!isset($this->counters[$key])) {
            $this->counters[$key] = [];
        }
        if (!isset($this->counters[$key][$level])) {
            $this->counters[$key][$level] = new Atomic(0);
        }
        return $this->counters[$key][$level];
    }
}