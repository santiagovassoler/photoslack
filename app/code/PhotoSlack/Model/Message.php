<?php

namespace PhotoSlack\Model;

use PhotoSlack\Api\Data\SlackDataInterface;

/**
 * @implements SlackDataInterface
 */
class Message extends AbstractEmoji implements SlackDataInterface
{
    /* @var string ts */
    private $ts;

    /* @var string $text */
    private $text;

    /* @var array imageList */
    private $imageList = [];

    /**
     * @return string
     */
    public function getTs() : string
    {
        return $this->ts;
    }

    /**
     * @return string
     */
    public function getText() : string
    {
        return $this->text;
    }

    /**
     * @return array
     */
    public function getImageList() : array
    {
        return $this->imageList;
    }

    /**
     * @param $ts
     * @return Message
     */
    public function setTs($ts) : Message
    {
        $this->ts = $ts;
        return $this;
    }

    /**
     * @param $text
     * @return Message
     */
    public function setText($text) : Message
    {
        $this->text = $this->formatTextWithEmoji($text);
        return $this;
    }

    /**
     * @param $list
     * @return Message
     */
    public function setImageList($list) : Message
    {
        $this->imageList = $list;
        return $this;
    }
}
