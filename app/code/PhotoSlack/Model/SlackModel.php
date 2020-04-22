<?php

namespace PhotoSlack\Model;

use PhotoSlack\Api\Data\SlackDataInterface;
use PhotoSlack\Model\EmojiDataInterface;

class SlackModel extends AbstractEmoji implements SlackDataInterface
{
    private $ts;

    private $text;

    private $imageList = [];

    public function getTs()
    {
        return $this->ts;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getImageList()
    {
        return $this->imageList;
    }

    public function setTs($ts)
    {
        $this->ts = $ts;
        return $this;
    }

    public function setText($text)
    {
        $this->text = $this->formatTextWithEmoji($text);
        return $this;
    }

    public function setImageList($list)
    {
        return $this->imageList = $list;
    }
}
