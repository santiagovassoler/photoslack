<?php

namespace PhotoSlack\Api\Data;

interface SlackDataInterface
{
    const SLACK_API_URL = 'https://slack.com/api/';

    const SLACK_API_TOKEN = getenv('SLACK_API_TOKEN');
    const SLACK_METHOD = [
        'search.all' => 'search.all',
        'reactions.list' => 'reactions.list',
        'reactions.get' => 'reactions.get',
        'search.files' => 'search.files',
        'files.info' => 'files.info',
        'conversations.history' => 'conversations.history'
    ];

    const SLACK_MESSAGE = 'message';

    const SLACK_MESSAGES = 'messages';

    const SLACK_REACTIONS = 'reactions';

    const SLACK_PERMALINK_PUBLIC = 'permalink_public';

    const SLACK_PUBLIC_URL_SHARED = 'public_url_shared';

    const SLACK_FILE = 'files';

    const SLACK_URL_PRIVATE = 'url_private';

    const SLACK_TS = 'ts';

    const SLACK_TEXT = 'text';

    const SLACK_PUB_SECRET = '?pub_secret=';

    const SLACK_REACTION_NAME = 'name';

    const SLACK_REACTION_COUNT = 'count';
}
