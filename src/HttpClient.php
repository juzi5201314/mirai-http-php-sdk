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

    // 无法复用HttpClient，
    // private HClient $client;

    /**
     * @param string $url
     * @return Promise<Response>
     */
    public function http_get(string $url): Promise {
        return call(function () use($url) {
            $client = HttpClientBuilder::buildDefault();
            $request = new Request($url, 'GET');
            return yield $client->request($request);
        });
    }

    public function http_post(string $url, ?string $body) {
        return call(function () use($url, $body) {
            $client = HttpClientBuilder::buildDefault();
            $request = new Request($url, 'POST', $body);
            return yield $client->request($request);
        });
    }

    // 无法复用HttpClient，如果复用会出现未知的异常
    /*public function http_client(): HClient {
        if (empty($this->client)) {
            $this->client = HttpClientBuilder::buildDefault();
        }
        return $this->client;
    }*/
}