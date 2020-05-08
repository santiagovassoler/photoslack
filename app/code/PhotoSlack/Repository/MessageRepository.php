<?php

namespace PhotoSlack\Repository;

use PhotoSlack\Api\Data\SlackDataInterface;

class SlackRepository extends AbstractRepository implements RepositoryInterface, SlackDataInterface
{
    /** @var ReactionFactoryInterface */
    private $reactionFactoryInterface;

    /** @var MessageFactoryInterface */
    private $messageFactoryInterface;

    /**
     * SlackRepository constructor.
     * @param ReactionFactoryInterface $reactionFactoryInterface
     * @param MessageFactoryInterface $messageFactoryInterface
     */
    public function __construct(
        ReactionFactoryInterface $reactionFactoryInterface,
        MessageFactoryInterface $messageFactoryInterface
    )
    {
        $this->reactionFactoryInterface = $reactionFactoryInterface;
        $this->messageFactoryInterface = $messageFactoryInterface;
    }

    /**
     * @param $ts
     * @return array
     */
    public function show($ts) : array
    {
        $collection = $this->getCollection();
        $reaction = $this->getReactions($ts);

        $message = array_filter($collection['collection'], function($data) use ($ts) {
            return $ts === $data->getTs() ?? $data->getImageList();
        });

        return ['reaction' => $reaction, 'messages' => $message];
    }

    /**
     * @param $ts
     * @return array
     */
    public function getReactions($ts) : array
    {
        $result = $this->queryAPI('reactions.get',
            [
                'channel' => 'CUW08F325',
                'timestamp' => $ts
            ]);
        if(isset($result[self::SLACK_MESSAGE][self::SLACK_REACTIONS])) {
           return array_map([$this->reactionFactoryInterface, 'create'], $result[self::SLACK_MESSAGE][self::SLACK_REACTIONS]);
        }
        return [];
    }

    /**
     * @return array
     */
    public function getCollection() : array
    {
        $result = $this->queryAPI('conversations.history', ['channel' => 'CUW08F325']);
        $collection = ['collection'=> array_map([$this->messageFactoryInterface, 'create'], $result[self::SLACK_MESSAGES])];

        return array_map('array_filter', $collection);
    }
}
