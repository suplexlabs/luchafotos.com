<?php

namespace App\Spiders\Middleware;

use Illuminate\Support\Facades\Http;
use Psr\Log\LoggerInterface;
use RoachPHP\Http\Response;
use RoachPHP\Downloader\Middleware\ResponseMiddlewareInterface;
use RoachPHP\Support\Configurable;
use Throwable;

class BrowserlessMiddleware implements ResponseMiddlewareInterface
{
    use Configurable;

    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    public function handleResponse(Response $response): Response
    {
        try {
            $url = $response->getRequest()->getUri();
            $body = Http::get('https://www.smarkbot.xyz/api/get/page', ['url' => $url])->body();
        } catch (Throwable $e) {
            $this->logger->info('[BrowserlessMiddleware] Error while getting page', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $response->drop('Error while getting page');
        }

        return $response->withBody($body);
    }
}
