<?php
namespace NeuroBro\Models\Claude\Models;

use NeuroBro\Contracts\AINetwork;
use NeuroBro\Contracts\Price;

class ClaudeOpusModel extends ClaudeHaikuModel
{
    public function __construct(
        AINetwork $network,
        Price $inputPrice,
        Price $outputPrice
    ) {
        parent::__construct($network, $inputPrice, $outputPrice, 10, 600);
    }

    public function getName(): string
    {
        return 'opus';
    }

    public function getMaxTokens(): int
    {
        return 300000;
    }
}