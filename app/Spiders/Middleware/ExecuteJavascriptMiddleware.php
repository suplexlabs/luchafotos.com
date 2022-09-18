<?php

namespace App\Spiders\Middleware;

use Psr\Log\LoggerInterface;
use RoachPHP\Http\Response;
use RoachPHP\Downloader\Middleware\ResponseMiddlewareInterface;
use RoachPHP\Support\Configurable;
use Spatie\Browsershot\Browsershot;
use Throwable;

class ExecuteJavascriptMiddleware implements ResponseMiddlewareInterface
{
    use Configurable;

    /**
     * @var callable(string): Browsershot
     */
    private $getBrowsershot;

    /**
     * @param null|callable(string): Browsershot $getBrowsershot
     */
    public function __construct(
        private LoggerInterface $logger,
        ?callable $getBrowsershot = null,
    ) {
        $this->getBrowsershot = $getBrowsershot ?: static fn (string $uri): Browsershot => Browsershot::url($uri);
    }

    public function handleResponse(Response $response): Response
    {
        $browsershot = $this->configureBrowsershot(
            $response->getRequest()->getUri(),
        );

        try {
            $body = $browsershot->bodyHtml();
        } catch (Throwable $e) {
            $this->logger->info('[ExecuteJavascriptMiddleware] Error while executing javascript', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $response->drop('Error while executing javascript');
        }

        return $response->withBody($body);
    }

    /**
     * @psalm-suppress MixedArgument, MixedAssignment
     */
    private function configureBrowsershot(string $uri): Browsershot
    {
        $browsershot = ($this->getBrowsershot)($uri);

        if (!empty($this->option('chromiumArguments'))) {
            $browsershot->addChromiumArguments($this->option('chromiumArguments'));
        }

        if (null !== ($chromePath = $this->option('chromePath'))) {
            $browsershot->setChromePath($chromePath);
        }

        if (null !== ($binPath = $this->option('binPath'))) {
            $browsershot->setBinPath($binPath);
        }

        if (null !== ($nodeModulePath = $this->option('nodeModulePath'))) {
            $browsershot->setNodeModulePath($nodeModulePath);
        }

        if (null !== ($includePath = $this->option('includePath'))) {
            $browsershot->setIncludePath($includePath);
        }

        if (null !== ($nodeBinary = $this->option('nodeBinary'))) {
            $browsershot->setNodeBinary($nodeBinary);
        }

        if (null !== ($npmBinary = $this->option('npmBinary'))) {
            $browsershot->setNpmBinary($npmBinary);
        }

        if (null !== ($wsEndpoint = $this->option('wsEndpoint'))) {
            $browsershot->setWSEndpoint($wsEndpoint);
        }

        return $browsershot;
    }

    private function defaultOptions(): array
    {
        return [
            'chromiumArguments' => [],
            'chromePath' => null,
            'binPath' => null,
            'nodeModulePath' => null,
            'includePath' => null,
            'nodeBinary' => null,
            'npmBinary' => null,
            'wsEndpoint' => null
        ];
    }
}
