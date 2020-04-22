<?php

namespace PhotoSlack\Repository;


interface RepositoryInterface
{
    public function getCollection();

    public function show($ts);

    public function getDataAsArray(string $apiUrl, string $apiToken, array $methodArray, string $method, array $argument);

    public function getRequest(array $request);

    public function getPublicSecret(string $key);

    public function queryAPI(string $method, array $params);
}
