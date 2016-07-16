<?php


namespace App\Gateways;

use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter
{
    public static $ID = 'id';

    public static $STATUS = 'status';

    public static $MEDIA = 'media';

    public static $MEDIA_IDS = 'media_ids';

    private $twitter;

    public function __construct($client_id, $client_secret, $access_token, $access_token_secret)
    {
        $this->twitter = new TwitterOAuth($client_id, $client_secret, $access_token, $access_token_secret);
    }

    public function get($search) {
        return $this->twitter->get("search/tweets", $search);
    }
}