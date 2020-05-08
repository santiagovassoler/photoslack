<?php

namespace PhotoSlack\Repository;

use PhotoSlack\Model\Image;
use PhotoSlack\Model\Message;

interface MessageFactoryInterface
{
    public function create($data);
}
