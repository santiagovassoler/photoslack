<?php

namespace PhotoSlack\Model;

use PhotoSlack\Api\Data\SlackImageInterface;

class SlackImage implements SlackImageInterface
{
    /* @var string ts */
    private  $ts;

    /* @var string imageUrl */
    private  $imageUrl;

    /* @var string permalinkPublic */
    private  $permalinkPublic;

    /* @var string publicUrlShared */
    private  $publicUrlShared;

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
    public function getImageUrl() : string
    {
        return $this->imageUrl;
    }

    /**
     * @return string
     */
    public function getPermalinkPublic() : string
    {
        return $this->permalinkPublic;
    }

    /**
     * @return string
     */
    public function getPublicUrlShared() : string
    {
        return $this->publicUrlShared;
    }

    /**
     * @param String $ts
     * @return SlackImage
     */
    public function setTs($ts) : SlackImage
    {
        $this->ts = $ts;
        return $this;
    }

    /**
     * @param String $image
     * @return SlackImage
     */
    public function setImageUrl($image) : SlackImage
    {
        $this->imageUrl = $image;
        return $this;
    }

    /**
     * @param String $link
     * @return SlackImage
     */
    public function setPermalinkPublic($link) : SlackImage
    {
        $this->permalinkPublic = $link;
        return $this;
    }

    /**
     * @param bool $boolValue
     * @return SlackImage
     */
    public function setPublicUrlShared($boolValue) : SlackImage
    {
        $this->publicUrlShared = $boolValue;
        return $this;
    }
}
