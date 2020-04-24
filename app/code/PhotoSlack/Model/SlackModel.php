<?php

namespace PhotoSlack\Model;

use PhotoSlack\Api\Data\SlackDataInterface;
use PhotoSlack\Model\EmojiDataInterface;

/**
 * @implements SlackDataInterface
 */
class SlackModel extends AbstractEmoji implements SlackDataInterface
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
     * @return SlackModel
     */
    public function setTs($ts) : SlackModel
    {
        $this->ts = $ts;
        return $this;
    }

    /**
     * @param $text
     * @return SlackModel
     */
    public function setText($text) : SlackModel
    {
        $this->text = $this->formatTextWithEmoji($text);
        return $this;
    }

    /**
     * @param $list
     * @return SlackModel
     */
    public function setImageList($list) : SlackModel
    {
        return $this->imageList = $list;
    }
}
