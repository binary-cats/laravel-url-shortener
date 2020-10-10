<?php

namespace BinaryCats\UrlShortener\Tests\Integration;

use BinaryCats\UrlShortener\Http\IsGdShortener;
use BinaryCats\UrlShortener\Tests\Concerns\HasUrlAssertions;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use PHPUnit\Framework\TestCase;

class IsGdShortenerTest extends TestCase
{
    use HasUrlAssertions;

    /**
     * @var \BinaryCats\UrlShortener\Http\IsGdShortener
     */
    protected $shortener;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->shortener = new IsGdShortener(new Client, 'https://is.gd', false);
    }

    /**
     * Test Is.gd synchronous shortening.
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
     * Test Is.gd asynchronous shortening.
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
