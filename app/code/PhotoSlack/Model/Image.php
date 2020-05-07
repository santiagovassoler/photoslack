<?php

namespace PhotoSlack\Model;

use PhotoSlack\Api\Data\SlackImageInterface;

class Image implements SlackImageInterface
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
     * @return Image
     */
    public function setTs($ts) : Image
    {
        $this->ts = $ts;
        return $this;
    }

    /**
     * @param String $image
     * @return Image
     */
    public function setImageUrl($image) : Image
    {
        $this->imageUrl = $image;
        return $this;
    }

    /**
     * @param String $link
     * @return Image
     */
    public function setPermalinkPublic($link) : Image
    {
        $this->permalinkPublic = $link;
        return $this;
    }

    /**
     * @param bool $boolValue
     * @return Image
     */
    public function setPublicUrlShared($boolValue) : Image
    {
        $this->publicUrlShared = $boolValue;
        return $this;
    }
}
