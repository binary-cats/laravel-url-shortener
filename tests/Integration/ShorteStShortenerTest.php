<?php

namespace BinaryCats\UrlShortener\Tests\Integration;

use BinaryCats\UrlShortener\Http\ShorteStShortener;
use BinaryCats\UrlShortener\Tests\Concerns\HasUrlAssertions;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use PHPUnit\Framework\TestCase;

class ShorteStShortenerTest extends TestCase
{
    use HasUrlAssertions;

    /**
     * @var \BinaryCats\UrlShortener\Http\ShorteStShortener
     */
    protected $shortener;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        if (!$token = getenv('SHORTE_ST_API_TOKEN')) {
            $this->markTestSkipped('No Shorte.st API token set');
        }

        $this->shortener = new ShorteStShortener(new Client, $token);
    }

    /**
     * Test Shorte.st synchronous shortening.
     *
     * @return void
     */
    public function testShorten()
    {
        $shortUrl = $this->shortener->shorten('https://google.com');

        $this->assertValidUrl($shortUrl);
    }

    /**
     * Test Shorte.st asynchronous shortening.
     *
     * @return void
     */
    public function testShortenAsync()
    {
        $promise = $this->shortener->shortenAsync('https://google.com');

        $this->assertInstanceOf(PromiseInterface::class, $promise);
        $this->assertValidUrl($shortUrl = $promise->wait());
    }
}
