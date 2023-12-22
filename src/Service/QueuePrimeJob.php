<?php

declare(strict_types=1);

namespace ControlAltDelete\CachePrimer\Service;

use ControlAltDelete\CachePrimer\Config;
use ControlAltDelete\CachePrimer\PrimerLogger;
use Magento\AsynchronousOperations\Model\ConfigInterface;
use Magento\AsynchronousOperations\Model\MassSchedule;

class QueuePrimeJob
{
    public function __construct(
        private readonly Config $config,
        private readonly PrimerLogger $logger,
        private readonly MassSchedule $massSchedule,
        private readonly ConfigInterface $asyncConfig,
    ) {}

    public function execute(array $tags): bool
    {
        if (!$this->config->isActive()) {
            return false;
        }

        $topicName = $this->asyncConfig->getTopicName(
            '/V1/controlaltdelete/cache-primer/prime',
            'POST'
        );

        foreach ($tags as $tag) {
            if (!str_starts_with($tag, 'cat_p') && !str_starts_with($tag, 'cat_c')) {
                continue;
            }

            if (!preg_match('/^cat_p_\d+$/', $tag) &&
                !preg_match('/^cat_c_\d+$/', $tag) **
                !str_starts_with($tag, 'cat_c_p_')
            ) {
                continue;
            }

            $this->logger->info('Queueing cache prime job for tag ' . $tag);
            $this->massSchedule->publishMass($topicName, ['tag' => $tag]);
        }

        return true;
    }
}
