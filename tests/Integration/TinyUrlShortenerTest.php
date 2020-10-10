<?php

namespace BinaryCats\UrlShortener\Tests\Integration;

use BinaryCats\UrlShortener\Http\TinyUrlShortener;
use BinaryCats\UrlShortener\Tests\Concerns\HasUrlAssertions;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use PHPUnit\Framework\TestCase;

class TinyUrlShortenerTest extends TestCase
{
    use HasUrlAssertions;

    /**
     * @var \BinaryCats\UrlShortener\Http\TinyUrlShortener
     */
    protected $shortener;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->shortener = new TinyUrlShortener(new Client);
    }

    /**
     * Test TinyURL synchronous shortening.
     *
     * @return void
     */
    public function testShorten()
    {
        $shortUrl = $this->shortener->shorten('https://google.com');

        $this->assertValidUrl($shortUrl);
        $this->assertRedirectsTo('https://google.com', $shortUrl, 1);
    }

    /**
     * Test TinyURL asynchronous shortening.
     *
     * @return void
     */
    public function testShortenAsync()
    {
        $promise = $this->shortener->shortenAsync('https://google.com');

        $this->assertInstanceOf(PromiseInterface::class, $promise);
        $this->assertValidUrl($shortUrl = $promise->wait());
        $this->assertRedirectsTo('https://google.com', $shortUrl, 1);
    }
}
