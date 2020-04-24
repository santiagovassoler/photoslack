<?php

namespace PhotoSlack\Repository;


interface RepositoryInterface
{
    public function getCollection() : array;

    public function show($ts) : array;

    public function getDataAsArray(string $apiUrl, string $apiToken, array $methodArray, string $method, array $argument) : array;

    public function getRequest(array $request) : string;

    public function getPublicSecret(string $key): string;

    public function queryAPI(string $method, array $params): array;
}
