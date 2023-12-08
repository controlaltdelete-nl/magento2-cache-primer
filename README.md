# Control Alt Delete Cache Primer

This extension is designed to prime the cache of your Magento shop when the cache is flushed for any of your products or categories. It does this by using Magento's built-in queue system. More information on how this is done can be found [in this blogpost](https://www.michiel-gerritsen.com/leveraging-the-queue-in-magento-2-in-a-simple-way).

## Installation

```
composer require controlaltdelete/magento2-cache-primer

bin/magento setup:upgrade
```

## Configuration

Under `Stores > Configuration > Services > Control Alt Delete Cache Primer` you can configure the extension.

At this moment there is only an option to enable or disable the queuing of prime jobs.

## Logging

The extension logs to `var/log/controlaltdelete_cache_primer.log`. It logs when a job is queued, but also when a job is executed.
