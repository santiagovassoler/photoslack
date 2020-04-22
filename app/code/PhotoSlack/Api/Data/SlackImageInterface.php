<?php

namespace PhotoSlack\Api\Data;

interface SlackImageInterface
{
    public function getTs();

    public function getImageUrl();

    public function getPermalinkPublic();

    public function getPublicUrlShared();

    public function setTs(String $ts);

    public function setImageUrl(String $image);

    public function setPermalinkPublic(String $link);

    public function setPublicUrlShared(Bool $boolValue);

}
