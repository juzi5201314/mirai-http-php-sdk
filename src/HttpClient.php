<?php

namespace MiraiSdk;

use Amp\Promise;
use Amp\Http\Client\{HttpClientBuilder, HttpClient as HClient, Request, Response};
use function Amp\call;

/**
 * Trait HttpClient
 * 实现http客户端，发送get和post请求
 */
trait HttpClient {
    /** @var HClient $client */
    private $client;

    /**
     * @param string $url
     * @return Promise<Response>
     */
    public function http_get(string $url): Promise {
        return call(function () use($url) {
            $client = $this->http_client();
            $request = new Request($url, 'GET');
            return yield $client->request($request);
        });
    }

    public function http_post(string $url, ?string $body) {
        return call(function () use($url, $body) {
            $client = $this->http_client();
            $request = new Request($url, 'GET', $body);
            return yield $client->request($request);
        });
    }

    public function http_client(): HClient {
        if ($this->client == null) {
            $this->client = HttpClientBuilder::buildDefault();
        }
        return $this->client;
    }
}