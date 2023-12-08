<?php

declare(strict_types=1);

namespace ControlAltDelete\CachePrimer\Service;

use ControlAltDelete\CachePrimer\PrimerLogger;
use Magento\Catalog\Api\CategoryListInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\HTTP\Client\Curl;

class PrimeActiveCategories
{
    public function __construct(
        private readonly CategoryListInterface $categoryList,
        private readonly SearchCriteriaBuilder $searchCriteriaBuilder,
        private readonly Curl $curl,
        private readonly PrimerLogger $logger,
    ) {}


    public function execute(): bool
    {
        $this->searchCriteriaBuilder->addFilter('is_active', true);

        $categories = $this->categoryList->getList($this->searchCriteriaBuilder->create());
        foreach ($categories->getItems() as $category) {
            $this->logger->info('Priming category ' . $category->getId(), [$category->getUrl()]);
            $this->fetchUrl($category->getUrl());
        }

        return true;
    }

    private function fetchUrl(string $url): bool
    {
        $this->curl->get($url);

        return $this->curl->getStatus() === 200;
    }
}
