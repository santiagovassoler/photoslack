<?php

namespace PhotoSlack\Model;

class ReactionModel extends AbstractEmoji
{
    /* @var string name */
    private $name;

    /* @var string count */
    private $count;

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCount() : string
    {
        return $this->count;
    }

    /**
     * @param $name
     * @return ReactionModel
     */
    public function setName($name) : ReactionModel
    {
        $this->name = $this->formatTextWithEmoji($name);
        return $this;
    }

    /**
     * @param $count
     * @return ReactionModel
     */
    public function setCount($count) : ReactionModel
    {
        $this->count = $count;
        return $this;
    }
}