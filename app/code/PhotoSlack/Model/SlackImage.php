<?php

namespace PhotoSlack\Model;

use PhotoSlack\Api\Data\SlackImageInterface;

class SlackImage implements SlackImageInterface
{
    private  $ts;
    private  $imageUrl;
    private  $permalinkPublic;
    private  $publicUrlShared;

    public function getTs() : string
    {
        return $this->ts;
    }

    public function getImageUrl() : string
    {
        return $this->imageUrl;
    }

    public function getPermalinkPublic() : string
    {
        return $this->permalinkPublic;
    }

    public function getPublicUrlShared() : string
    {
        return $this->publicUrlShared;
    }

    public function setTs($ts) : SlackImage
    {
        $this->ts = $ts;
        return $this;
    }

    public function setImageUrl($image) : SlackImage
    {
        $this->imageUrl = $image;
        return $this;
    }

    public function setPermalinkPublic($link) : SlackImage
    {
        $this->permalinkPublic = $link;
        return $this;
    }

    public function setPublicUrlShared($boolValue) : SlackImage
    {
        $this->publicUrlShared = $boolValue;
        return $this;
    }
}
