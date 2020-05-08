<?php

namespace PhotoSlack\Repository;

use PhotoSlack\Api\Data\SlackDataInterface;

abstract class AbstractRepository implements SlackDataInterface
{
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
}
