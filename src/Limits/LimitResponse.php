<?php
namespace NeuroBro\Contracts\Limits;

readonly class LimitResponse implements \JsonSerializable
{
    /** @var LimitValue[] */
    private array $data;

    /**
     * @param LimitValue[] $limits
     */
    public function __construct(array $limits)
    {
        // Сортируем по уровню лимита
        usort($limits, fn($a, $b) => $a->getLevel()->value - $b->getLevel()->value);
        $this->data = $limits;
    }

    /**
     * @return LimitValue[]
     */
    public function getData(): array
    {
        return $this->data;
    }

    public function jsonSerialize(): array
    {
        $response = [];
        foreach ($this->data as $limit) {
            $response[] = [
                'level' => $limit->getLevel()->name,
                'level_value' => $limit->getLevel()->value,
                'seconds' => $limit->getSeconds(),
                'remaining' => $limit->getRemaining()
            ];
        }

        return [
            'limits' => $response,
            'explanation' => 'Limits are ordered by level. If any level is exhausted, requests should be stopped regardless of other levels availability.'
        ];
    }
}