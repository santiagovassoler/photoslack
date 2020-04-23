<?php

namespace PhotoSlack\Api\Data;

use PhotoSlack\Model\SlackImage;

interface SlackImageInterface
{
    public function getTs() : string ;

    public function getImageUrl() : string ;

    public function getPermalinkPublic() : string ;

    public function getPublicUrlShared() : string ;

    public function setTs(String $ts) : SlackImage ;

    public function setImageUrl(String $image) : SlackImage ;

    public function setPermalinkPublic(String $link) : SlackImage ;

    public function setPublicUrlShared(Bool $boolValue) : SlackImage ;

}
