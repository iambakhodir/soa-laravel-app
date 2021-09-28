<?php
namespace App\Services\JsonRpc;
use Illuminate\Support\Facades\Http;

class JsonRpcClient
{
    const JSON_RPC_VERSION = "2.0";

    protected string $url;
    protected array $headers;

    public function __construct(string $url, array $headers = [])
    {
        $this->url = $url;
        $this->headers = $headers;
    }

    /**
     * @param string $method
     * @param array $params
     * @return array|null
     */
    public function send(string $method, array $params): ?array
    {
        $res = Http::timeout(5)
            ->withHeaders(array_merge([
                'Content-type' => 'application/json'
            ], $this->headers))
            ->post($this->url, [
                'jsonrpc' => self::JSON_RPC_VERSION,
                'id' => time(),
                'method' => $method,
                'params' => $params,
            ]);

        if ($res->successful())
            return $res->json();

        return null;
    }
}