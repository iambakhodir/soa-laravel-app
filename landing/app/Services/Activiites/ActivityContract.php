<?php
namespace App\Services\Activities;

interface ActivityContract
{
    public function create($url): void;
    public function show(int $page): array;
}