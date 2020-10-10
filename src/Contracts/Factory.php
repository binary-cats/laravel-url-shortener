<?php

namespace BinaryCats\UrlShortener\Contracts;

interface Factory
{
    /**
     * Get a shortener instance.
     *
     * @param string|null $name
     * @return \BinaryCats\UrlShortener\Contracts\Shortener
     */
    public function shortener(string $name = null);
}
