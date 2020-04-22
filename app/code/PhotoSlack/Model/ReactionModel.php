<?php

namespace PhotoSlack\Model;

class ReactionModel extends AbstractEmoji
{
    private $name;

    private $count;

    public function getName()
    {
        return $this->name;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function setName($name)
    {
        $this->name = $this->formatTextWithEmoji($name);
        return $this;
    }

    public function setCount($count)
    {
        $this->count = $count;
        return $this;
    }
}