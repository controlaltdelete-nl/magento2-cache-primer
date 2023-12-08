<?php

namespace ControlAltDelete\CachePrimer\Api;

interface PrimerInterface
{
    /**
     * @param string $tag
     * @return bool
     */
    public function prime(string $tag): bool;
}
