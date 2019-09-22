<!--
This file is intended to demonstrate to the programmer how to use the api core function of SmsEdgeApi Class
You can enter the documentation for more details
https://developers.smsedge.io/v1/reference
-->

<?php
include "src/SmsEdgeApi.php";

// =========================== Init Api class =============================================================================================================================================================================================== //

$sms_edge_api = new SmsEdgeApi(''); // api_key is required.


// =========================== References =================================================================================================================================================================================================== //


// =========================== Getting all available API functions =============================================== //

$functions = $sms_edge_api->getFunctions();

echo '<pre>';
print_r(json_decode($functions));
die();

// ===============================================================================================================//


// =========================== Getting all HTTP response status codes =========================================== //

$http_statues = $sms_edge_api->getHttpStatuses();

echo '<pre>';
print_r(json_decode($http_statues));
die();

// ===============================================================================================================//


// =========================== Getting list of countries ======================================================== //

$countries = $sms_edge_api->getCountries();

echo '<pre>';
print_r(json_decode($countries));
die();

// ===============================================================================================================//


// =========================== SMS ========================================================================================================================================================================================================== //


// =========================== Send a single SMS =============================================== //

// Params details:

// Required params:
// from, The sender of the SMS (11 characters max)
// to, SMS receiver phone number, in international format (f.e 12127678347 - US number)
// text, Text of SMS

// Optional params:
// name, Value for custom name variable in text provided
// email, Value for custom email variable in text provided
// country_id, ID of country. Recommended to specify this parameter if phone number provided in local format
// reference, Unique value per message, to prevent double submission
// shorten_url, If true will search for a URL (http://example.com) in the message and will shorten it so it’ll be click trackable. Will short the first URL in the text
// list_id, Phone number of recipient can be added to list with this ID
// transactional, show Label for transactional messages
// preferred_route_id, Use this param if you want to send SMS via specific Route
// delay, If you want to delay sending, set this parameter (in seconds)

$send_single_sms_array = [
    'from' => 'SNDR_ID',
    'to' => 12127678347,
    'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
    'name' => 'John Doe',
    'email' => 'johndoe@email.com',
    'country_id' => '1', // List of countries on getCountries() function.
    'reference' => 'some_string',
    'shorten_url' => true, // By default false.
    'list_id' => 1,
    'transactional' => true,
    'preferred_route_id' => '1', // List of routes on getRoutes() function.
    'delay' => '10', // Delay by seconds
];

$single_sms = $sms_edge_api->sendSingleSms($send_single_sms_array);

echo '<pre>';
print_r($single_sms);
die();

// ============================================================================================= //


// =========================== Bulk SMS sending =============================================== //

// Params details:

// Required params:
// list_id, Messages will be sent to all good numbers from list with this ID
// from, The sender of the SMS (11 characters max)

// text, Text of SMS -> Usage of custom variables in text: name, lname, email, custom1, custom2, custom3, custom4, custom5
// For example: Hello, {{{name}}} {{{lname}}}! Please visit my site: http://smsedge.io/

// Optional params:
// shorten_url, If true will search for a URL (http://example.com) in the message and will shorten it so it’ll be click trackable. Will short the first URL in the text
// preferred_route_id, Use this param if you want to send SMS via specific Route

$send_list_array = [
    'list_id' => 1,
    'from' => 'SNDR_ID',
    'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
    'shorten_url' => '', // By default false.
    'preferred_route_id' => '', // List of routes on getRoutes() function.
];

$send_list = $sms_edge_api->sendList($send_list_array);

echo '<pre>';
print_r($send_list);
die();

// ============================================================================================= //


// =========================== Get SMS information ============================================= //

// Params details:

// Required params:
// ids, Comma-separated SMS ids

$sms_info_array = [
    'ids' => '1,4,27',
];

$sms_info = $sms_edge_api->getSmsInfo($sms_info_array);

echo '<pre>';
print_r($sms_info);
die();

// ============================================================================================= //


// =========================== LISTS OF NUMBERS ========================================================================================================================================================================================================= //


// =========================== Create a new list =============================================== //

// Params details:

// Required params:
// name, Name of the new list

$new_list_array = [
    'name' => 'My list',
];

$new_list = $sms_edge_api->createList($new_list_array);

echo '<pre>';
print_r($new_list);
die();

// ============================================================================================= //


// =========================== Delete a list =================================================== //

// Params details:

// Required params:
// id, ID of list that wanted to be deleted

$delete_list_array = [
    'id' => 1,
];

$delete_list = $sms_edge_api->deleteList($delete_list_array);

echo '<pre>';
print_r($delete_list);
die();

// ============================================================================================= //


// =========================== Get list information ============================================ //

// Params details:

// Required params:
// id, ID of requested list

$list_info_array = [
    'id' => 1,
];

$list_info = $sms_edge_api->getListInfo($list_info_array);

echo '<pre>';
print_r($list_info);
die();

// ============================================================================================= //


// =========================== Get all lists =================================================== //

$lists = $sms_edge_api->getAllLists();

echo '<pre>';
print_r($lists);
die();

// ============================================================================================= //


// =========================== PHONE NUMBERS =================================================================================================== //

// =========================== Add a number to list =================================================== //

// Params details:

// Required params:
// number, Phone number of recipient
// list_id, Number will be added to list with this ID

// Optional params:
// country_id, ID of country. Recommended to specify this parameter if phone number provided in local format
// name, Name of recipient
// email, E-mail of recipient

$new_number_array = [
    'number' => '',
    'list_id' => 1,
    'country_id' => 1,
    'name' => 'John Doe',
    'email' => 'john_doe@email.com',
];

$new_number = $sms_edge_api->createNumber($new_number_array);

echo '<pre>';
print_r($new_number);
die();

// ============================================================================================= //


// =========================== Delete a number =================================================== //

// Params details:

// Required params:
// ids, Comma-separated IDs of numbers to be deleted

$delete_numbers_array = [
    'ids' => '1,32,27',
];

$delete_numbers = $sms_edge_api->deleteNumber($delete_numbers_array);

echo '<pre>';
print_r($delete_number);
die();

// ============================================================================================= //


// =========================== Get numbers ===================================================== //

// Params details:

// Optional params:
// list_id, Numbers from list with this id will be return
// ids, Comma-separated IDs of numbers
// limit, Limit of numbers to be returned per request. Max: 1000
// offset, By specifying offset, you retrieve a subset of records starting with the offset value.

// At least one of parameters: List ID or IDs of numbers should be specified!.

$get_numbers_array = [
    'list_id' => 1,
    'limit' => 1000,
];

$numbers = $sms_edge_api->getNumbers($get_numbers_array);

echo '<pre>';
print_r($numbers);
die();

// ============================================================================================= //


// =========================== Get unsubscribers ===================================================== //

$unsubscribers = $sms_edge_api->getUnsubscribers();

echo '<pre>';
print_r($unsubscribers);
die();

// ============================================================================================= //


// =========================== ROUTES =================================================================================================== //


// =========================== Get all routes ===================================================== //

$routes = $sms_edge_api->getRoutes();

echo '<pre>';
print_r($routes);
die();

// ============================================================================================= //


// =========================== AUXILIARY TOOLS =================================================================================================== //


// =========================== Number Simple Verification ===================================================== //

// Params details:

// Required params:
// number, Phone number that should be verified

// Optional params:
// country_id, ID of country. Recommended to specify this parameter if phone number provided in local format


$simple_number_array = [
    'number' => 12127678347,
    'country_id' => 1,
];

$check_simple_number = $sms_edge_api->numberSimpleVerify($simple_number_array);

echo '<pre>';
print_r($check_simple_number);
die();

// ============================================================================================= //


// =========================== Number HLR Verification ====================================================== //

// Params details:

// Required params:
// number, Phone number that should be verified

// Optional params:
// country_id, ID of country. Recommended to specify this parameter if phone number provided in local format


$hlr_number_array = [
    'number' => 12127678347,
    'country_id' => 1,
];

$check_hlr_number = $sms_edge_api->numberHlrVerify($hlr_number_array);

echo '<pre>';
print_r($check_hlr_number);
die();

// ============================================================================================= //


// =========================== Text Analyzing =========================================================== //

// Params details:

// Required params:
// text, Text of SMS you want to verify before sending

$text_analyze_array = [
    'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
];

$text_analyze = $sms_edge_api->textAnalyzing($text_analyze_array);

echo '<pre>';
print_r($text_analyze);
die();

// ============================================================================================= //


// =========================== REPORTS =================================================================================================== //


// =========================== Sending Process Report =========================================================== //

// Params details:

// Optional params:
// status, Filter result by SMS sending status. Available values: sent, waiting, failed
// date_from, Filter results by minimum date
// date_to, Filter results by maximum date
// limit, Limit of items to be returned per request. Max: 1000
// offset, By specifying offset, you retrieve a subset of records starting with the offset value.

$send_process_array = [
    'status' => 'sent',
    'date_from' => date('Y-m-d H:i:s', strtotime('-5 days')), // Five days ago
    'date_to' => date('Y-m-d H:i:s'), // Now
    'limit' => 1000,
];

$send_process = $sms_edge_api->getSendingReport($send_process_array);

echo '<pre>';
print_r($send_process);
die();

// ============================================================================================= //


// =========================== Statistics =========================================================== //

// Params details:

// Required Params:
// country_id, ID of Country
// date_from, Filter results by minimum date
// date_to, Filter results by maximum date. Maximal period - 7 days

// Optional params:
// route_id, ID of Route

$send_stats_array = [
    'country_id' => 1, // List of countries on getCountries() function.
    'date_from' => date('Y-m-d H:i:s', strtotime('-5 days')), // Five days ago
    'date_to' => date('Y-m-d H:i:s'), // Now
    'route_id' => 1, // List of routes on getRoutes() function.
];

$send_stats = $sms_edge_api->getSendingStats($send_stats_array);

echo '<pre>';
print_r($send_stats);
die();

// ============================================================================================= //

// =========================== USER =================================================================================================== //


// =========================== User Details =========================================================== //

$user = $sms_edge_api->getUserDetails();

echo '<pre>';
print_r($user);
die();

// ============================================================================================= //
