<?php

namespace PhotoSlack\Repository;

use PhotoSlack\Api\Data\SlackDataInterface;
use PhotoSlack\Model\ReactionModel;
use PhotoSlack\Model\SlackImage;
use PhotoSlack\Model\SlackModel;

class SlackRepository implements RepositoryInterface, SlackDataInterface
{
    /**
     * @param $ts
     * @return array
     */
    public function show($ts) : array
    {
        $images = $this->getCollection();
        $img = [];

        foreach ($images['collection'] as $key => $image){
            if($ts === $image->getTs()){
                $img = $image->getImageList();
            }
        }

        $reaction = $this->getReactions($ts);

        return ['image' => $img, 'reaction' => $reaction];
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
     * @param $ts
     * @return array
     */
    public function getReactions($ts) : array
    {
        $data = [];
        $result = $this->queryAPI('reactions.get',
            [
                'channel' => 'CUW08F325',
                'timestamp' => $ts
            ]);
        if(isset($result[self::SLACK_MESSAGE][self::SLACK_REACTIONS])) {
            foreach ($result[self::SLACK_MESSAGE][self::SLACK_REACTIONS] as $reactions) {
                $reaction = new ReactionModel();
                $reaction
                    ->setName(':' . $reactions['name'] . ':')
                    ->setCount($reactions['count']);
                $data[] = $reaction;
            }
        }
        return $data;
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
     * @return array
     */
    public function getCollection() : array
    {
        $collection = [];
        $result = $this->queryAPI('conversations.history', ['channel' => 'CUW08F325']);

        if(array_key_exists(self::SLACK_MESSAGES, $result)){
            foreach ($result[self::SLACK_MESSAGES] as $key => $value){
                if(array_key_exists(self::SLACK_FILE, $value) && isset($value['text']) && strpos($value[self::SLACK_TEXT], '#dog') !== false){

                    $list = [];
                    foreach ($value['files'] as $file) {
                        $image = new SlackImage;
                        $image
                            ->setTs($value[self::SLACK_TS])
                            ->setPermalinkPublic($file[self::SLACK_PERMALINK_PUBLIC])
                            ->setPublicUrlShared($file[self::SLACK_PUBLIC_URL_SHARED])
                            ->setImageUrl($file[self::SLACK_URL_PRIVATE]. '?pub_secret=' . $this->getPublicSecret($file[self::SLACK_PERMALINK_PUBLIC]));

                        $list[] = $image;
                    }

                    $slackModel = new SlackModel;
                    $slackModel
                        ->setTs($value[self::SLACK_TS])
                        ->setText($value[self::SLACK_TEXT])
                        ->setImageList($list);

                    $collection[]  = $slackModel;
                }
            }
        }

        return ['collection' => $collection];
    }
}
