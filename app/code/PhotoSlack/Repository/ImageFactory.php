<?php

namespace PhotoSlack\Repository;

use PhotoSlack\Api\Data\SlackDataInterface;
use PhotoSlack\Model\Image;

class ImageFactory implements SlackDataInterface, ImageFactoryInterface
{
    /**
     * @param $data
     * @param $ts
     * @return Image
     */
    public function create($data, $ts) : Image
    {
        if(is_array($data)) {
            $image = new Image;
            $image
                ->setTs($ts)
                ->setPermalinkPublic($data[self::SLACK_PERMALINK_PUBLIC])
                ->setPublicUrlShared($data[self::SLACK_PUBLIC_URL_SHARED])
                ->setImageUrl($data[self::SLACK_URL_PRIVATE] .
                    self::SLACK_PUB_SECRET . $this->getPublicSecret($data[self::SLACK_PERMALINK_PUBLIC]));
            return $image;
        }
    }

    /**
     * @param string $url
     * @return string
     */
    private function getPublicSecret($url) : string
    {
        return substr($url, strrpos($url, '-') + 1);
    }
}
