<?php

declare(strict_types=1);

namespace ControlAltDelete\CachePrimer\Service;

use ControlAltDelete\CachePrimer\PrimerLogger;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product\Url;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Store\Model\StoreManagerInterface;

class PrimeProduct
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly Url $urlModel,
        private readonly StoreManagerInterface $storeManager,
        private readonly PrimerLogger $logger,
        private readonly Curl $curl,
    ) {}

    public function execute(string $productId): bool
    {
        $product = $this->productRepository->getById($productId);

        $urls = [];
        foreach ($this->storeManager->getStores() as $store) {
            $urls[] = $this->urlModel->getUrl($product, ['_store' => $store->getId()]);
        }

        $this->logger->info('Priming product ' . $productId, $urls);

        $allGood = true;
        foreach (array_unique($urls) as $url) {
            if (!$this->fetchUrl($url)) {
                $allGood = false;
            }
        }

        return $allGood;
    }

    private function fetchUrl(string $url): bool
    {
        $this->curl->get($url);

        return $this->curl->getStatus() === 200;
    }
}
