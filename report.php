<?php
//
// This project is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This project is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this project.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Landing page for Portal Demo
 *
 * @copyright  2019 Matt Porritt <mattp@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Require all the things.
require_once('config.php');
require_once('setup.php');
require_once('./classes/esrequest.php');

//  Get the student info from the LMS.
$client = new \portal_request\esrequest();
$method = 'core_user_get_users';
$url = $CFG->webservice_end_point . $method;

$query = array('criteria' => array());
$jsonquery = json_encode($query);
$response = $client->post($url, $jsonquery)->getBody();
$results = json_decode($response, true);

// Itterate through the results filtering out users
// That haven't logged in recently
$users = array();
$timestamp = strtotime('today midnight');

foreach ($results['users'] as $result) {
    if($result['lastlogin'] < $timestamp) {
        $users[] = $result;
    }
}

// Load the main template.
$m = new Mustache_Engine(array(
        'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '/assets/templates'),
));


// Render the template.
echo $m->render('report', array('users' => $users));
