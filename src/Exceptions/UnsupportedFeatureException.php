<?php
namespace NeuroBro\Exceptions;

class UnsupportedFeatureException extends AIException
{
    public static function attachmentsNotSupported(string $modelName): self
    {
        return (new self("Model {$modelName} doesn't support attachments"))
            ->setContext([
                'model' => $modelName,
                'feature' => 'attachments'
            ]);
    }

    public static function imagesNotSupported(string $modelName): self
    {
        return (new self("Model {$modelName} doesn't support image analysis"))
            ->setContext([
                'model' => $modelName,
                'feature' => 'image_analysis'
            ]);
    }

    public static function unsupportedFileType(string $modelName, string $fileType): self
    {
        return (new self("File type {$fileType} not supported by model {$modelName}"))
            ->setContext([
                'model' => $modelName,
                'file_type' => $fileType,
                'feature' => 'file_type'
            ]);
    }
}