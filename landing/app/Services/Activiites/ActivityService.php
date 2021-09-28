<?php

namespace App\Services\Activities;

use Carbon\Carbon;
use App\Services\JsonRpc\JsonRpcClient;


class ActivityService implements ActivityContract
{
    private JsonRpcClient $client;

    public function __construct()
    {
        $this->client = new JsonRpcClient(config("services.activity_service.url"), [
            "Authorization" => "Bearer " . config("services.activity_service.token")
        ]);
    }

    public function create($url): void
    {
        $this->client->send(config("services.activity_service.method.create"), [
            'url' => $url,
            'visit_date' => Carbon::now()->format("Y-m-d H:i:s")
        ]);
    }

    public function show(int $page): array
    {
        $res = $this->client->send(config("services.activity_service.method.show"), [
            'page' => $page
        ]);

        if (!$res)
            return [];

        return $res;
    }
}