<?php
namespace NeuroBro\Models\Claude\Models;

class ClaudeSonnetModel extends ClaudeHaikuModel
{
    public function __construct(
        AINetwork $network,
        Price $inputPrice,
        Price $outputPrice
    ) {
        parent::__construct($network, $inputPrice, $outputPrice, 5, 300);
    }

    public function getName(): string
    {
        return 'sonnet';
    }

    public function getMaxTokens(): int
    {
        return 200000;
    }
}