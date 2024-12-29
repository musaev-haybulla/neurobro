<?php
namespace NeuroBro\Contracts;

readonly class Price
{
    public function __construct(
        private float $amount,
        private string $currency,
        private string $unit
    ) {}

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }
}