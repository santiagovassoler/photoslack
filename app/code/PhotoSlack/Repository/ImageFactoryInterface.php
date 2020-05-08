<?php

namespace PhotoSlack\Repository;

use PhotoSlack\Model\Image;

interface ImageFactoryInterface
{
    public function create($data, $ts) : Image;
}
