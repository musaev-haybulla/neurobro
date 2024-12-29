<?php
namespace NeuroBro\Models\Claude;

use NeuroBro\Models\Base\AbstractNetwork;

class ClaudeNetwork extends AbstractNetwork
{
    public function getName(): string
    {
        return 'claude';
    }
}