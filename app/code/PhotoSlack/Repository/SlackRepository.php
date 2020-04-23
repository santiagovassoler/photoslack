<?php

namespace PhotoSlack\Repository;

use PhotoSlack\Api\Data\SlackDataInterface;
use PhotoSlack\Model\ReactionModel;
use PhotoSlack\Model\SlackImage;
use PhotoSlack\Model\SlackModel;

class SlackRepository implements RepositoryInterface, SlackDataInterface
{
    public function show($ts)
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

    public function getDataAsArray(string $apiUrl, string $apiToken, array $methodArray, string $method, array $argument)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getFormattedURL($apiUrl, $apiToken,  $methodArray, $method, $argument));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $data = curl_exec($ch);
        curl_close($ch);

        return json_decode($data, true);
    }

    private function getFormattedURL(String $apiUrl, String $apiToken, Array $methodArray, String $method, Array $argument)
    {
        return $apiUrl . $methodArray[$method] . '?token=' . $apiToken . $this->getRequest($argument);
    }

    public function getRequest(Array $request)
    {
        $formattedRequest = '';
        foreach ($request as $key => $value) {
            $formattedRequest .= '&' . $key . '=' . $value;
        }
        return $formattedRequest;
    }

    public function getReactions($ts)
    {
        $data = [];
        $result = $this->queryAPI('reactions.get',
            [
                'channel' => 'CUW08F325',
                'timestamp' => $ts
            ]);
        if(isset($result['message']['reactions'])) {
            foreach ($result['message']['reactions'] as $reactions) {
                $reaction = new ReactionModel();
                $reaction
                    ->setName(':' . $reactions['name'] . ':')
                    ->setCount($reactions['count']);
                $data[] = $reaction;
            }
        }
        return $data;
    }

    public function queryAPI(string $method, array $params)
    {
        return $this->getDataAsArray(
            self::SLACK_API_URL,
            self::SLACK_API_TOKEN_HISTORY,
            self::SLACK_METHOD,
            $method,
            $params
        );
    }

    public function getPublicSecret($url)
    {
        return substr($url, strrpos($url, '-') + 1);
    }

    public function getCollection()
    {
        $collection = [];
        $result = $this->queryAPI('conversations.history', ['channel' => 'CUW08F325',]);

        if(array_key_exists('messages', $result)){
            foreach ($result['messages'] as $key => $value){
                if(array_key_exists(self::SLACK_FILE, $value) && isset($value['text']) && strpos($value['text'], '#dog') !== false){

                    $slackModel = new SlackModel;

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
