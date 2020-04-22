<?php

namespace PhotoSlack\Model;

use PhotoSlack\Api\Data\SlackImageInterface;

class SlackImage implements SlackImageInterface
{
    private  $ts;
    private  $imageUrl;
    private  $permalinkPublic;
    private  $publicUrlShared;

    public function getTs()
    {
        return $this->ts;
    }

    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    public function getPermalinkPublic()
    {
        return $this->permalinkPublic;
    }

    public function getPublicUrlShared()
    {
        return $this->publicUrlShared;
    }

    public function setTs($ts)
    {
        $this->ts = $ts;
        return $this;
    }

    public function setImageUrl($image)
    {
        $this->imageUrl = $image;
        return $this;
    }

    public function setPermalinkPublic($link)
    {
        $this->permalinkPublic = $link;
        return $this;
    }

    public function setPublicUrlShared($boolValue)
    {
        $this->publicUrlShared = $boolValue;
        return $this;
    }
}
