<?php

declare(strict_types=1);

namespace ControlAltDelete\CachePrimer;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class PrimerLogger extends Logger
{
    public function __construct(
        array $handlers = [],
        array $processors = []
    ) {
        parent::__construct('Control Alt Delete Cache Primer', $handlers, $processors);

        $this->pushHandler(
            new StreamHandler(
                BP . '/var/log/controlaltdelete_cache_primer.log',
                Logger::DEBUG
            )
        );
    }
}
