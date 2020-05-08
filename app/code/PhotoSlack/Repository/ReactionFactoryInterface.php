<?php

namespace PhotoSlack\Repository;

use PhotoSlack\Model\Reaction;

interface ReactionFactoryInterface
{
    public function create($data) : Reaction;
}
