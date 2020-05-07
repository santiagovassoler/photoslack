<?php

namespace PhotoSlack\Api\Data;

use PhotoSlack\Model\Image;

interface SlackImageInterface
{
    public function getTs() : string ;

    public function getImageUrl() : string ;

    public function getPermalinkPublic() : string ;

    public function getPublicUrlShared() : string ;

    public function setTs(String $ts) : Image ;

    public function setImageUrl(String $image) : Image ;

    public function setPermalinkPublic(String $link) : Image ;

    public function setPublicUrlShared(Bool $boolValue) : Image ;

}
