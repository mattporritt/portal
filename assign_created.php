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

// Get for data.
$courseid = $_POST['courseid'];
$name = $_POST['name'];
$desc = $_POST['description'];
$date = strtotime ($_POST['date']);
$enddate = strtotime ($_POST['enddate']);

//  create some groups.
$client = new \portal_request\esrequest();
$method = 'local_createassign_create_assign';
$url = $CFG->webservice_end_point . $method;

$assign = array(
    'courseid' => $courseid,
    'name' => $name,
    'description' => $desc,
    'startdate' => $date,
    'duedate' => $enddate
        );


$query = array('assign' => $assign);
$jsonquery = json_encode($query);
error_log($jsonquery);
$response = $client->post($url, $jsonquery)->getBody();
$results = json_decode($response, true);

error_log(print_r($results, true));

// Load the main template.
$m = new Mustache_Engine(array(
        'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '/assets/templates'),
));


// Render the template.
echo $m->render('assign_created', array());
