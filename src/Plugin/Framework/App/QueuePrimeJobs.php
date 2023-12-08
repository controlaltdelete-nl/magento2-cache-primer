<?php

declare(strict_types=1);

namespace ControlAltDelete\CachePrimer\Plugin\Framework\App;

use ControlAltDelete\CachePrimer\Service\QueuePrimeJob;
use Magento\Framework\App\Cache;

class QueuePrimeJobs
{
    public function __construct(
        private readonly QueuePrimeJob $queuePrimeJob,
    ) {}

    /**
     * @see \Magento\Framework\App\Cache::clean
     */
    public function afterClean(Cache $subject, bool $result, array $tags = []): bool
    {
        $this->queuePrimeJob->execute($tags);

        return $result;
    }
}
