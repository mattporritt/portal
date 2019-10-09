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

//  create some groups.
$client = new \portal_request\esrequest();
$method = 'core_group_create_groups';
$url = $CFG->webservice_end_point . $method;

$groups = array();
$groups[0] = array(
        'courseid' => 134,
        'name' => 'Group A',
        'description' => 'Group_A'
        );
$groups[1] = array(
        'courseid' => 134,
        'name' => 'Group B',
        'description' => 'Group_B'
);

$query = array('groups' => $groups);
$jsonquery = json_encode($query);
$response = $client->post($url, $jsonquery)->getBody();
$results = json_decode($response, true);

$group1 = $results[0]['id'];
$group2 = $results[1]['id'];

// Put students in the groups.
$method = 'core_group_add_group_members';
$url = $CFG->webservice_end_point . $method;

$members = array();
$members[0] = array(
        'groupid' => $group1,
        'userid' => 5,
);
$members[1] = array(
        'groupid' => $group1,
        'userid' => 6,
);
$members[2] = array(
        'groupid' => $group1,
        'userid' => 7,
);
$members[3] = array(
        'groupid' => $group1,
        'userid' => 8,
);
$members[4] = array(
        'groupid' => $group1,
        'userid' => 9,
);
$members[5] = array(
        'groupid' => $group1,
        'userid' => 10,
);
$members[6] = array(
        'groupid' => $group1,
        'userid' => 11,
);
$members[7] = array(
        'groupid' => $group1,
        'userid' => 12,
);
$members[8] = array(
        'groupid' => $group1,
        'userid' => 13,
);
$members[9] = array(
        'groupid' => $group1,
        'userid' => 14,
);
$members[10] = array(
        'groupid' => $group2,
        'userid' => 15,
);
$members[11] = array(
        'groupid' => $group2,
        'userid' => 16,
);
$members[12] = array(
        'groupid' => $group2,
        'userid' => 17,
);
$members[13] = array(
        'groupid' => $group2,
        'userid' => 18,
);
$members[14] = array(
        'groupid' => $group2,
        'userid' => 19,
);
$members[15] = array(
        'groupid' => $group2,
        'userid' => 20,
);
$members[16] = array(
        'groupid' => $group2,
        'userid' => 21,
);
$members[17] = array(
        'groupid' => $group2,
        'userid' => 22,
);
$members[18] = array(
        'groupid' => $group2,
        'userid' => 23,
);
$members[19] = array(
        'groupid' => $group2,
        'userid' => 24,
);

$query = array('members' => $members);
$jsonquery = json_encode($query);
$response = $client->post($url, $jsonquery)->getBody();
$results = json_decode($response, true);

$method = 'core_group_assign_grouping';
$url = $CFG->webservice_end_point . $method;

$grouping = array();
$grouping[0] = array(
        'groupingid' => 1,
        'groupid' => $group1,
);
$grouping[1] = array(
        'groupingid' => 1,
        'groupid' => $group2,

);

$query = array('assignments' => $grouping);
$jsonquery = json_encode($query);
$response = $client->post($url, $jsonquery)->getBody();
$results = json_decode($response, true);

// Load the main template.
$m = new Mustache_Engine(array(
        'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '/assets/templates'),
));


// Render the template.
echo $m->render('groups_created', array());
