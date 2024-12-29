<?php
namespace NeuroBro\Registry;

use NeuroBro\Contracts\AINetwork;
use NeuroBro\Contracts\AIModel;
use NeuroBro\Models\Claude\ClaudeNetwork;
use NeuroBro\Models\Claude\Models\{ClaudeHaikuModel, ClaudeSonnetModel, ClaudeOpusModel};
use NeuroBro\Contracts\Price;
use NeuroBro\Exceptions\ModelNotFoundException;

class AINetworkRegistry
{
    /** @var array<string, AINetwork> */
    private array $networks = [];

    /** @var array<string, array<string, AIModel>> */
    private array $models = [];

    public function __construct(array $config)
    {
        $this->initializeNetworks($config);
    }

    private function initializeNetworks(array $config): void
    {
        foreach ($config as $networkName => $networkConfig) {
            $network = match($networkName) {
                'claude' => $this->initializeClaudeNetwork($networkConfig),
                // Другие сети будут добавлены здесь
                default => throw new ModelNotFoundException("Unknown network: {$networkName}")
            };

            $this->networks[$networkName] = $network;
        }
    }

    private function initializeClaudeNetwork(array $config): AINetwork
    {
        $network = new ClaudeNetwork($config['base_url']);

        // Инициализация моделей Claude
        $this->models['claude'] = [
            'haiku' => new ClaudeHaikuModel(
                $network,
                new Price(...$config['models']['haiku']['input_price']),
                new Price(...$config['models']['haiku']['output_price'])
            ),
            'sonnet' => new ClaudeSonnetModel(
                $network,
                new Price(...$config['models']['sonnet']['input_price']),
                new Price(...$config['models']['sonnet']['output_price'])
            ),
            'opus' => new ClaudeOpusModel(
                $network,
                new Price(...$config['models']['opus']['input_price']),
                new Price(...$config['models']['opus']['output_price'])
            )
        ];

        return $network;
    }

    public function getNetwork(string $name): ?AINetwork
    {
        return $this->networks[$name] ?? null;
    }

    public function getModel(string $networkName, string $modelName): ?AIModel
    {
        return $this->models[$networkName][$modelName] ?? null;
    }
}