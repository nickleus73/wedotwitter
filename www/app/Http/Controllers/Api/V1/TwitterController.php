<?php

namespace App\Http\Controllers\Api\V1;

use App\Business\Services\TwitterService;
use App\Exceptions\AppException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @Controller(prefix="api/v1/tweets")
 */
class TwitterController extends Controller {

    private $twitter;

    public function __construct() {
        $this->twitter = new TwitterService();
    }

    /**
     * @Post("/")
     */
    public function getTweets(Request $request) {
        $search = $request->input('search');
        $count = $request->input('count');

        try {
            $response = $this->twitter->get(array(
                'q' => $search,
                'count' => $count
            ));
        } catch (AppException $e) {
            return json_encode(array(
                'error' => true
            ));
        }

        return json_encode($response);
    }
}