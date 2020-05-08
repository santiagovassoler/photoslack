<?php

namespace PhotoSlack\Repository;

use PhotoSlack\Api\Data\SlackDataInterface;
use PhotoSlack\Model\Message;

class MessageFactory implements SlackDataInterface, MessageFactoryInterface
{
    /** @var ImageFactoryInterface */
    private $imageFactoryInterface;

    public function __construct(ImageFactoryInterface $imageFactoryInterface)
    {
        $this->imageFactoryInterface = $imageFactoryInterface;
    }

    /**
     * @param $data
     * @return Message|null
     */
    public function create($data)
    {
        if(array_key_exists(self::SLACK_FILE, $data) &&
            isset($data[self::SLACK_TEXT]) && strpos($data[self::SLACK_TEXT], '#dog') !== false){
            $message = new Message;
            $message
                ->setTs($data[self::SLACK_TS])
                ->setText($data[self::SLACK_TEXT])
                ->setImageList(array_map([$this->imageFactoryInterface, 'create'], $data[self::SLACK_FILE], [$data[self::SLACK_TS]]));
            return $message;
        }
    }
}
