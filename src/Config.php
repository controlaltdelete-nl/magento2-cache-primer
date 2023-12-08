<?php

declare(strict_types=1);

namespace ControlAltDelete\CachePrimer;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig,
    ) {}

    public function isActive(): bool
    {
        return $this->scopeConfig->isSetFlag('controlaltdelete_cache_primer/general/active');
    }
}
