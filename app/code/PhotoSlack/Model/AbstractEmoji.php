<?php

namespace PhotoSlack\Model;

use PhotoSlack\Api\Data\EmojiDataInterface;

abstract class AbstractEmoji implements EmojiDataInterface
{
    /**
     * {@inheritdoc}
     */
    public function formatTextWithEmoji($text) : string
    {
        $array = self::EMOJI;

        return preg_replace_callback(/** @lang text */ "/(:[\w+-]+:)/", function (array $matches) use ($array) {
            foreach ($matches as $ma) {
                if (array_key_exists($ma, $array)) {
                    return $array[$matches[1]];
                }
                return $matches[1];
            }
        }, $text);
    }
}