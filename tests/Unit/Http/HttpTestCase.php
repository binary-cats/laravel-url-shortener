<?php

namespace BinaryCats\UrlShortener\Tests\Unit\Http;

use BinaryCats\UrlShortener\Tests\Concerns\HasUrlAssertions;
use PHPUnit\Framework\TestCase;

abstract class HttpTestCase extends TestCase
{
    use HasUrlAssertions;

    /**
     * @var \BinaryCats\UrlShortener\Tests\Unit\Http\MockClient
     */
    protected $client;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        $this->client = new MockClient();
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown(): void
    {
        if ($this->client->hasQueuedMessages()) {
            $this->fail(sprintf('HTTP client contains %d unused message(s)', $this->client->getQueueSize()));
        }
    }
}
