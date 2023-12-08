<?php

declare(strict_types=1);

namespace ControlAltDelete\CachePrimer\Webapi;

use ControlAltDelete\CachePrimer\Api\PrimerInterface;
use ControlAltDelete\CachePrimer\Service\PrimeActiveCategories;
use ControlAltDelete\CachePrimer\Service\PrimeCategory;
use ControlAltDelete\CachePrimer\Service\PrimeProduct;

class Primer implements PrimerInterface
{
    public function __construct(
        private readonly PrimeCategory $primeCategory,
        private readonly PrimeProduct $primeProduct,
        private readonly PrimeActiveCategories $primeActiveCategories,
    ) {}

    public function prime(string $tag): bool
    {
        // Check if the tag is in form cat_p_123
        if (preg_match('/^cat_p_\d+$/', $tag)) {
            return $this->primeProduct->execute(substr($tag, strlen('cat_p_')));
        }

        if (preg_match('/^cat_c_\d+$/', $tag) || str_starts_with($tag, 'cat_c_p_')) {
            return $this->primeCategory->execute(substr($tag, strlen('cat_c_')));
        }

        if ($tag == 'cat_c') {
            return $this->primeActiveCategories->execute();
        }

        return false;
    }
}
