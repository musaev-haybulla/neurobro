<?php
namespace NeuroBro\Exceptions;

class ModelNotFoundException extends AIException
{
    public static function modelNotFound(string $networkName, string $modelName): self
    {
        return (new self("Model {$modelName} not found in network {$networkName}"))
            ->setContext([
                'network' => $networkName,
                'model' => $modelName
            ]);
    }

    public static function networkNotFound(string $networkName): self
    {
        return (new self("Network {$networkName} not found"))
            ->setContext([
                'network' => $networkName
            ]);
    }
}
