<?php


namespace MiraiSdk;

use Amp\Http\Client\HttpException;
use Amp\Http\Client\Response;
use Amp\Promise;
use GuzzleHttp\Client;
use function Amp\call;
use function MiraiSdk\utils\map_promise;

trait Api {
    use HttpClient;

    private string $session;

    public abstract function get_config(): BotConfig;
    public abstract function get_qq(): int;

    /**
     * 返回message id
     *
     * @param int $group_id
     * @param array $msg_chain
     * @param int|null $quote
     * @return Promise<int>
     */
    public function send_group_message(int $group_id, array $msg_chain, ?int $quote = null): Promise {
        $body = [
            "sessionKey" => $this->session,
            "group" => $group_id,
            "messageChain" => $msg_chain
        ];
        if (!empty($quote))
            $body["quote"] = $quote;
        return map_promise(
            $this->send_api('/sendGroupMessage', $body),
            fn($res) => $res['messageId']
        );
    }

    /**
     * 返回message id
     *
     * @param int $qq
     * @param array $msg_chain
     * @param int|null $quote
     * @return Promise<int>
     */
    public function send_friend_message(int $qq, array $msg_chain, ?int $quote = null): Promise {
        $body = [
            "sessionKey" => $this->session,
            "qq" => $qq,
            "messageChain" => $msg_chain
        ];
        if (!empty($quote))
            $body["quote"] = $quote;
        return map_promise(
            $this->send_api('/sendFriendMessage', $body),
            fn($res) => $res['messageId']
        );
    }

    public function fetch_message(int $count): Promise {
        return map_promise(
            $this->get_api(sprintf("/fetchMessage?sessionKey=%s&count=%d", $this->session, $count)),
            fn($res) => $res['data']
        );
    }

    /**
     * 释放session，返回是否成功
     *
     * @return Promise<bool>
     */
    public function release(): Promise {
        return map_promise(
            $this->send_api('/release', ["sessionKey" => $this->session, "qq" => $this->get_qq()]),
            fn($res) => $res['code'] == 0
        );
    }

    /**
     * 同步释放session，返回是否成功
     * 用于在Loop关闭之后释放session
     *
     * @return bool
     */
    public function sync_release(): bool {
        try {
            $client = new Client();
            $response = $client->post($this->get_config()->addr . '/release', [
                "body" => json_encode(["sessionKey" => $this->session, "qq" => $this->get_qq()])
            ]);
            $res = self::handle_err(json_decode($response->getBody(), true));
            return $res['code'] == 0;
        } catch (\Throwable $throwable) {
            return false;
        }
    }

    /**
     * 激活session，返回是否成功
     *
     * @return Promise<bool>
     */
    public function verify(): Promise {
        return map_promise(
            $this->send_api('/verify', ["sessionKey" => $this->session, "qq" => $this->get_qq()]),
            fn($res) => $res['code'] == 0
        );
    }

    /**
     * 认证，并返回session key
     *
     * @param string $token
     * @return Promise<string>
     */
    public function auth(string $token): Promise {
        return map_promise(
            $this->send_api('/auth', ["authKey" => $token]),
            fn($res) => $this->session = $res['session']
        );
    }

    /**
     * 返回插件信息数组
     *
     * @return Promise<array>
     */
    public function about(): Promise {
        return map_promise(
            $this->get_api('/about'),
            fn($res) => $res['data']
        );
    }

    /**
     * @param array $res
     * @return array
     * @throws ApiError
     */
    private static function handle_err(array $res): array {
        if ($res['code'] != 0) {
            $err_msg = '';
            switch ($res['code']) {
                case 1:
                    $err_msg = '错误的auth key';
                    break;
                case 2:
                    $err_msg = '指定的Bot不存在';
                    break;
                case 3:
                    $err_msg = 'Session失效或不存在';
                    break;
                case 4:
                    $err_msg = 'Session未认证(未激活)';
                    break;
                case 5:
                    $err_msg = '发送消息目标不存在(指定对象不存在)';
                    break;
                case 6:
                    $err_msg = '指定文件不存在(发送本地图片)';
                    break;
                case 10:
                    $err_msg = '无操作权限';
                    break;
                case 20:
                    $err_msg = 'Bot被禁言';
                    break;
                case 30:
                    $err_msg = '消息过长';
                    break;
                case 400:
                    $err_msg = '错误的访问';
                    break;
                default:
                    $err_msg = '未知错误';
                    break;
            }
            throw new ApiError($err_msg, $res['code']);
        } else {
            return $res;
        }
    }

    /**
     * @param string $uri
     * @param array $data
     * @return Promise
     */
    public function send_api(string $uri, array $data): Promise {
        return call(function () use ($data, $uri) {
            return self::handle_err(yield $this->json_response_to_array($this->http_post($this->get_config()->addr . $uri, json_encode($data))));
        });
    }

    /**
     * @param string $uri
     * @return Promise
     */
    public function get_api(string $uri): Promise {
        return call(function () use ($uri) {
            return self::handle_err(yield $this->json_response_to_array($this->http_get($this->get_config()->addr . $uri)));
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
                if ($response->getStatus() != 200 && $response->getStatus() != 400) {
                    $request = $response->getRequest();
                    throw new ApiError(
                        sprintf("%s %s is not OK. HTTP code: %d",
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
