<?php

namespace PhotoSlack\Repository;

use PhotoSlack\Api\Data\SlackDataInterface;
use PhotoSlack\Model\Reaction;

class ReactionRepository implements ReactionFactoryInterface, SlackDataInterface
{
    /**
     * @param $data
     * @return Reaction
     */
    public function create($data) : Reaction
    {
        $reaction = new Reaction();
        $reaction
            ->setName(':' . $data[self::SLACK_REACTION_NAME] . ':')
            ->setCount($data[self::SLACK_REACTION_COUNT]);

        return $reaction;
    }
}
