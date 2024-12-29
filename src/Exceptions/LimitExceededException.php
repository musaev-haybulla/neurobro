<?php
namespace NeuroBro\Exceptions;

use NeuroBro\Contracts\Limits\LimitLevel;

class LimitExceededException extends AIException
{
    public static function limitExceeded(
        string $apiKey,
        LimitLevel $level,
        int $resetInSeconds
    ): self {
        return (new self("Rate limit exceeded for level {$level->name}. Reset in {$resetInSeconds} seconds"))
            ->setContext([
                'api_key' => $apiKey,
                'limit_level' => $level->name,
                'reset_in_seconds' => $resetInSeconds
            ]);
    }
}
