<?php

declare(strict_types=1);

namespace ControlAltDelete\CachePrimer\Service;

use ControlAltDelete\CachePrimer\PrimerLogger;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\HTTP\Client\Curl;

class PrimeCategory
{
    public function __construct(
        private readonly PrimerLogger $logger,
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly Curl $curl,
    ) {}

    public function execute(string $categoryId): bool
    {
        $category = $this->categoryRepository->get($categoryId);

        $this->logger->info('Priming category ' . $categoryId, [$category->getUrl()]);

        return $this->fetchUrl($category->getUrl());
    }

    private function fetchUrl(string $url): bool
    {
        $this->curl->get($url);

        return $this->curl->getStatus() === 200;
    }
}
