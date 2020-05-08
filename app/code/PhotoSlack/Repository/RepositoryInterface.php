<?php

namespace PhotoSlack\Repository;


interface RepositoryInterface
{
    public function getCollection() : array;

    public function show($ts) : array;
}
