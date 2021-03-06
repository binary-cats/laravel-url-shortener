<?php

namespace BinaryCats\UrlShortener\Tests\Integration;

use BinaryCats\UrlShortener\Http\IsGdShortener;
use BinaryCats\UrlShortener\Tests\Concerns\HasUrlAssertions;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class VGdShortenerTest extends TestCase
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
        $this->shortener = new IsGdShortener(new Client, 'https://v.gd', false);
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
        $this->assertTrue(Str::startsWith($shortUrl, 'https://v.gd'));
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
        $this->assertTrue(Str::startsWith($shortUrl, 'https://v.gd'));
    }
}
