<?php
namespace NeuroBro\Exceptions;

class RequestException extends AIException
{
    public static function invalidRequest(string $reason, array $details = []): self
    {
        return (new self("Invalid request: {$reason}"))
            ->setContext(array_merge(['reason' => $reason], $details));
    }

    public static function processingError(string $modelName, string $error): self
    {
        return (new self("Error processing request with model {$modelName}: {$error}"))
            ->setContext([
                'model' => $modelName,
                'error' => $error
            ]);
    }
}