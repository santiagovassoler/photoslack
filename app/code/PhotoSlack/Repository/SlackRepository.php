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

    public function getMessageData()
    {
        $message=[];
        $result = $this->queryAPI('search.all',
            [
                "query" => "%23dog",
                'sort'=>'timestamp'
            ]);

        foreach ($result[self::SLACK_MESSAGE][self::SLACK_MATCH] as $item){
            $message[$item[self::SLACK_TS]] = $item[self::SLACK_TEXT];
        }
        return $message;
    }

    public function getImagesData()
    {
        $collection = [];
        $result = $this->queryAPI('conversations.history', ['channel' => 'CUW08F325',]);

        if(array_key_exists('messages', $result)){
            foreach ($result['messages'] as $key => $value){
                if(array_key_exists(self::SLACK_FILE, $value) && isset($value['text']) && strpos($value['text'], '#dog') !== false){

                    $slackModel = new SlackModel;

                    $list = [];
                    foreach ($value['files'] as $file) {

                        $image      = new SlackImage;
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

        return $collection;
    }

    public function getImagesData_old()
    {
        $message = $this->getMessageData();
        $result = $this->queryAPI('search.all',
            [
                'query' => 'jpg',
                'sort'=>'timestamp'
            ]);
        $imageData = [];

        foreach($result[self::SLACK_FILE][self::SLACK_MATCH] as $key => $matches) {
            if (array_key_exists('shares', $matches)) {
                if (array_key_exists(
                        self::SLACK_PUBLIC, $matches[self::SLACK_SHARE]) &&
                    array_key_exists(
                        $matches[self::SLACK_SHARE][self::SLACK_PUBLIC]['CUW08F325'][self::SLACK_SHARE_ARRAY_POSITION][self::SLACK_TS],
                        $message)) {

                    $ts = $matches[self::SLACK_SHARE][self::SLACK_PUBLIC]['CUW08F325'][self::SLACK_SHARE_ARRAY_POSITION][self::SLACK_TS];
                    $picsUrl = $matches[self::SLACK_URL_PRIVATE] . '?pub_secret=' . $this->getPublicSecret($matches[self::SLACK_PERMALINK_PUBLIC]);

                    $image = new SlackImage();
                    $image
                        ->setImageUrl($picsUrl)
                        ->setTs($ts);

                    $imageData[$ts][] = $image;
                }
            }
        }
        return $imageData;
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
        return ["collection" => $this->getImagesData()];
    }
}
