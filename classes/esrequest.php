<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Provides request signing
 *
 * @package     search_elastic
 * @copyright   Matt Porritt <mattp@catalyst-au.net>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace portal_request;

// Require all the things.
require_once('config.php');
require_once('setup.php');

/**
 * Class creates the API calls to Elasticsearch.
 *
 * @copyright   Matt Porritt <mattp@catalyst-au.net>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class esrequest {
    /**
     * Initialises the search engine configuration.
     *
     * Search engine availability should be checked separately.
     *
     * @param \GuzzleHttp\HandlerStack $handler Optional custom Guzzle handler stack
     * @return void
     */
    public function __construct() {
        $this->client = new \GuzzleHttp\Client();
    }


    /**
     * Execute the HTTP action and return the response.
     * Requests that receive a 4xx or 5xx response will throw a
     * Guzzle\Http\Exception\BadResponseException.
     * Requests to a URL that does not resolve will raise a \GuzzleHttp\Exception\GuzzleException.
     * We want to handle this in a sane way and provide the caller with
     * a useful response. So we catch the error and return the
     * response.
     *
     * @param \GuzzleHttp\Psr7\Request $psr7request
     * @return \GuzzleHttp\Psr7\Response
     */
    private function http_action($psr7request) {
        try {
            $response = $this->client->send($psr7request);
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            $response = $e->getResponse();
        }

        return $response;
    }


    public function post($url, $params) {
        global $CFG;
        $headers = array(
                'content-type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => $CFG->weservice_key
        );
        $psr7request = new \GuzzleHttp\Psr7\Request('POST', $url, $headers, $params);

        $response = $this->http_action($psr7request);

        return $response;

    }


}
