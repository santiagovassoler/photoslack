<?php

namespace PhotoSlack\Repository;

use PhotoSlack\Api\Data\SlackDataInterface;
use PhotoSlack\Model\Reaction;
use PhotoSlack\Model\Image;
use PhotoSlack\Model\Message;

class SlackRepository implements RepositoryInterface, SlackDataInterface
{

    /**
     * @param $ts
     * @return array
     */
    public function show($ts) : array
    {
        $collection = $this->getCollection();
        $reaction = $this->getReactions($ts);

        $img = array_filter($collection['collection'], function($data) use ($ts) {
            return $ts === $data->getTs() ?? $data->getImageList();
        });

        return ['reaction' => $reaction, 'images' => $img];
    }

    /**
     * @param string $apiUrl
     * @param string $apiToken
     * @param array $methodArray
     * @param string $method
     * @param array $argument
     * @return array
     */
    public function getDataAsArray(string $apiUrl, string $apiToken, array $methodArray, string $method, array $argument) : array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getFormattedURL($apiUrl, $apiToken,  $methodArray, $method, $argument));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $data = curl_exec($ch);
        curl_close($ch);

        return json_decode($data, true);
    }

    /**
     * @param String $apiUrl
     * @param String $apiToken
     * @param array $methodArray
     * @param String $method
     * @param array $argument
     * @return string
     */
    private function getFormattedURL(String $apiUrl, String $apiToken, Array $methodArray, String $method, Array $argument) : string
    {
        return $apiUrl . $methodArray[$method] . '?token=' . $apiToken . $this->getRequest($argument);
    }

    /**
     * @param array $request
     * @return string
     */
    public function getRequest(Array $request) : string
    {
        $formattedRequest = '';
        foreach ($request as $key => $value) {
            $formattedRequest .= '&' . $key . '=' . $value;
        }
        return $formattedRequest;
    }

    /**
     * @param $data
     * @return Reaction
     */
    public function createReaction($data) : Reaction
    {
        $reaction = new Reaction();
        $reaction
            ->setName(':' . $data[self::SLACK_REACTION_NAME] . ':')
            ->setCount($data[self::SLACK_REACTION_COUNT]);
        return $reaction;
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
           return array_map([$this, 'createReaction'], $result[self::SLACK_MESSAGE][self::SLACK_REACTIONS]);
        }
        return [];
    }

    /**
     * @param string $method
     * @param array $params
     * @return array
     */
    public function queryAPI(string $method, array $params) : array
    {
        return $this->getDataAsArray(
            self::SLACK_API_URL,
            self::SLACK_API_TOKEN,
            self::SLACK_METHOD,
            $method,
            $params
        );
    }

    /**
     * @param string $url
     * @return string
     */
    public function getPublicSecret($url) : string
    {
        return substr($url, strrpos($url, '-') + 1);
    }

    /**
     * @param $data
     * @return Message|null
     */
    public function createSlackModel($data)
    {
        if(array_key_exists(self::SLACK_FILE, $data) &&
            isset($data[self::SLACK_TEXT]) && strpos($data[self::SLACK_TEXT], '#dog') !== false){
            $slackModel = new Message;
            $slackModel
                ->setTs($data[self::SLACK_TS])
                ->setText($data[self::SLACK_TEXT])
                ->setImageList(array_map([$this, 'createSlackImage'], $data[self::SLACK_FILE], [$data[self::SLACK_TS]]));
            return $slackModel;
        }
    }

    /**
     * @param $data
     * @param $ts
     * @return Image
     */
    public function createSlackImage($data, $ts) : Image
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
     * @return array
     */
    public function getCollection() : array
    {
        $result = $this->queryAPI('conversations.history', ['channel' => 'CUW08F325']);
        $collection = ['collection'=> array_map([$this, 'createSlackModel'], $result[self::SLACK_MESSAGES])];

        return array_map('array_filter', $collection);
    }
}
