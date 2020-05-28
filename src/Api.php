<?php


namespace MiraiSdk;

use Amp\Http\Client\HttpException;
use Amp\Http\Client\Response;
use Amp\Promise;
use function Amp\call;

trait Api {
    use HttpClient;

    /** @var string $addr */
    private $addr;

    public function send() {

    }

    public function get_api(string $uri) {
        return call(function () use ($uri) {
            $result = yield $this->json_response_to_array($this->http_get($this->addr . $uri));
            var_dump($result);
        });
    }

    /**
     * @param Promise<Response> $response
     * @return Promise<array>
     */
    private function json_response_to_array(Promise $response): Promise {
        return call(function () use ($response) {
            try {
                /** @var Response $response */
                $response = yield $response;
                if ($response->getStatus() != 200) {
                    $request = $response->getRequest();
                    throw new ApiError(
                        sprintf("%s %s is not OK. code: %d",
                            $request->getMethod(),
                            $request->getUri()->getPath(),
                            $response->getStatus()
                        ));
                }
                return json_decode(yield $response->getBody()->buffer(), true);
            } catch (HttpException $exception) {
                throw new ApiError("Http error: " . $exception->getMessage());
            } catch (\JsonException $exception) {
                throw new ApiError("Json parse error: " . $exception->getMessage());
            }
        });
    }
}
