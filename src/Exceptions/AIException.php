<?php
namespace NeuroBro\Exceptions;

class AIException extends \Exception
{
    protected ?array $context = null;

    public function setContext(array $context): self
    {
        $this->context = $context;
        return $this;
    }

    public function getContext(): ?array
    {
        return $this->context;
    }
}