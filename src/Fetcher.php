<?php

declare(strict_types=1);

namespace Ronnie\TRA;

use PHP_CodeSniffer\Tests\Core\Autoloader\B;
use Ronnie\TRA\Contracts\ResourceFetcher;
use Spatie\Browsershot\Browsershot;

class Fetcher implements ResourceFetcher
{
    private string $uri;
    private bool $test = false;

    public function __construct(?string $uri = null)
    {
        !is_null($uri) && $this->uri = $uri;
    }

    public function setUri(string $uri): self
    {
        $this->uri = $uri;

        return $this;
    }

    public function setTestMode(bool $testMode): self
    {
        $this->test = $testMode;

        return $this;
    }

    public function load(): string
    {
        if ($this->test) {
            return Browsershot::html(file_get_contents(dirname(__DIR__) . '/Dummy/Time.html'))->bodyHtml();
        }
        return Browsershot::url($this->uri)->timeout(150)->bodyHtml();
    }

    public function getUri(): string
    {
        return $this->uri;
    }
}
