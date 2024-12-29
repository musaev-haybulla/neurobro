<?php
namespace NeuroBro\Exceptions;

class ConfigurationException extends AIException
{
    public static function invalidConfiguration(string $parameter, string $reason): self
    {
        return (new self("Invalid configuration for parameter '{$parameter}': {$reason}"))
            ->setContext([
                'parameter' => $parameter,
                'reason' => $reason
            ]);
    }

    public static function missingRequiredParameter(string $parameter): self
    {
        return (new self("Missing required configuration parameter: {$parameter}"))
            ->setContext([
                'parameter' => $parameter
            ]);
    }
}