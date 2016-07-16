<?php

namespace App\Business\Services;

use App\Exceptions\AppException;
use App\Gateways\Twitter;
use Illuminate\Support\Facades\Config;

class TwitterService
{
    private $twitter;

    public function __construct() {
        $client_id = Config::get('services.twitter.client_id');
        $client_secret = Config::get('services.twitter.client_secret');
        $access_token = Config::get('services.twitter.access_token');
        $secret_token = Config::get('services.twitter.secret_token');

        $this->twitter = new Twitter($client_id, $client_secret, $access_token, $secret_token);
    }

    public function get($search) {
        if(!is_array($search)) {
            $search = array(
                'q' => $search
            );
        }

        if(empty($search["q"])) {
            throw new AppException("empty request");
        }
        
        return $this->twitter->get($search);
    }
}