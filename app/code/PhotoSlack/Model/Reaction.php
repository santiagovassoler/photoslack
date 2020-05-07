<?php

namespace PhotoSlack\Model;

class Reaction extends AbstractEmoji
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
     * @return Reaction
     */
    public function setName($name) : Reaction
    {
        $this->name = $this->formatTextWithEmoji($name);
        return $this;
    }

    /**
     * @param $count
     * @return Reaction
     */
    public function setCount($count) : Reaction
    {
        $this->count = $count;
        return $this;
    }
}
