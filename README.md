# SmsEdge API php exaples
* This repo is intended to demonstrate to the programmer how to use the api core function of SmsEdgeApi Class You can enter the documentation for more details
https://developers.smsedge.io/v1/reference


## Usage

* Copy src folder to your project.

* Create A php file to control the functions.
// Example: functions.php 

* On the created file include the SmsEdgeApi class.

```php
<?php
include "src/SmsEdgeApi.php";
```

* Make an object from the class.
```php
$sms_edge_api = new SmsEdgeApi(''); # Put you api key between the quotes.
```

* Then you can use api functions.

## SMS

#### Send a single SMS
```php
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

Result:

{
  "success": true,
  "data": {
    "id": 19591,
    "created": "2018-02-14 17:35:40",
    "from": "smsapi",
    "to": 6598943560,
    "country_id": 192,
    "country_name": "Singapore",
    "verify_local": 1,
    "shorten_url": 1,
    "list_id": 2070,
    "parts": 1,
    "reference": null,
    "clicked": false,
    "text": "Dear John (john@test.com), please visit my page http://page.com/",
    "status": "sent"
  },
  "errors": [],
  "response": {
    "code": 200,
    "description": "OK",
    "date": "2018-02-14 17:35:40"
  },
  "api": {
    "version": "v1",
    "module": "sms",
    "function": "send-single"
  },
  "user": {
    "id": 64
  }
}
```
#### Bulk SMS sending

```php
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

Result:

{
  "success": true,
  "data": [
    "7 message(s) have been sent"
  ],
  "errors": [],
  "response": {
    "code": 200,
    "description": "OK",
    "date": "2018-02-14 17:46:08"
  },
  "api": {
    "version": "v1",
    "module": "sms",
    "function": "send-list"
  },
  "user": {
    "id": 64
  }
}
```
#### Get SMS information

```php
// Params details:

// Required params:
// ids, Comma-separated SMS ids

$sms_info_array = [
    'ids' => '1,4,27',
];

$sms_info = $sms_edge_api->getSmsInfo($sms_info_array);

Result:

{
  "success": true,
  "data": [
    {
      "id": 18839,
      "created": "2018-02-11 10:14:30",
      "from": "smsapi",
      "to": 972535000000,
      "country_id": 104,
      "country_name": "Israel",
      "verify_local": 1,
      "shorten_url": 1,
      "list_id": null,
      "parts": 1,
      "reference": "some-external-id-1",
      "clicked": false,
      "cost": 0.006,
      "original_url": "http://page.com/",
      "shortened_url": "http://sho.rt/1ei4h",
      "text": "Please visit my page: http://sho.rt/1ei4h",
      "status": "sent",
      "dlr_status": "DELIVERED"
    },
    {
      "id": 18875,
      "created": "2018-02-13 11:52:17",
      "from": "smsapi",
      "to": 972535000001,
      "country_id": 104,
      "country_name": "Israel",
      "verify_local": 1,
      "shorten_url": 1,
      "list_id": 2065,
      "parts": 1,
      "reference": "some-external-id-1",
      "clicked": false,
      "cost": 0.006,
      "original_url": "http://page.com/",
      "shortened_url": "http://sho.rt/1ei4h",
      "text": "Please visit my page: http://sho.rt/1ei4h",
      "status": "waiting",
      "dlr_status": "QUEUED"
    }
  ],
  "errors": [
    "SMS with specified id [905] was not found"
  ],
  "response": {
    "code": 200,
    "description": "OK",
    "date": "2018-02-14 17:10:30"
  },
  "api": {
    "version": "v1",
    "module": "sms",
    "function": "get"
  },
  "user": {
    "id": 64
  }
}
```

## LISTS OF NUMBERS

#### Create a new list
```php
// Params details:

// Required params:
// name, Name of the new list

$new_list_array = [
    'name' => 'My list',
];

$new_list = $sms_edge_api->createList($new_list_array);

Result:

  "success": true,
  "data": {
    "id": 2071,
    "name": "Test List",
    "description": null,
    "status": "Finished",
    "created": "2018-02-14 15:39:39"
  },
  "errors": [],
  "response": {
    "code": 200,
    "description": "OK",
    "date": "2018-02-14 15:39:39"
  },
  "api": {
    "version": "v1",
    "module": "lists",
    "function": "create"
  },
  "user": {
    "id": 64
  }
}
```

#### Delete a list

```php
// Params details:

// Required params:
// id, ID of list that wanted to be deleted

$delete_list_array = [
    'id' => 1,
];

$delete_list = $sms_edge_api->deleteList($delete_list_array);

Result:

{
  "success": true,
  "data": {
    "message": "List [2071] has been deleted successfully"
  },
  "errors": [],
  "response": {
    "code": 200,
    "description": "OK",
    "date": "2018-02-14 15:43:00"
  },
  "api": {
    "version": "v1",
    "module": "lists",
    "function": "delete"
  },
  "user": {
    "id": 64
  }
}
```

#### Get list information

```php
// Params details:

// Required params:
// id, ID of requested list

$list_info_array = [
    'id' => 1,
];

$list_info = $sms_edge_api->getListInfo($list_info_array);

Result:

{
  "success": true,
  "data": {
    "id": 2065,
    "name": "Test List",
    "description": null,
    "status": "Finished",
    "created": "2018-02-11 10:19:28",
    "counts": [
      {
        "country_id": "13",
        "country_name": "Australia",
        "numbers_total": "39",
        "numbers_good": "11",
        "numbers_bad": "3",
        "numbers_clickers": "0",
        "numbers_sent": "0",
        "numbers_hlr_progress": "0",
        "numbers_waiting": "0"
      },
      {
        "country_id": "226",
        "country_name": "United States",
        "numbers_total": "7",
        "numbers_good": "0",
        "numbers_bad": "0",
        "numbers_clickers": "0",
        "numbers_sent": "0",
        "numbers_hlr_progress": "0",
        "numbers_waiting": "0"
      }
    ]
  },
  "errors": [],
  "response": {
    "code": 200,
    "description": "OK",
    "date": "2018-02-14 15:40:59"
  },
  "api": {
    "version": "v1",
    "module": "lists",
    "function": "info"
  },
  "user": {
    "id": 64
  }
}
```

#### Get all lists

```php
$lists = $sms_edge_api->getAllLists();

Result:

{
  "success": true,
  "data": [
    {
      "id": 2070,
      "name": "Test List 1",
      "description": null,
      "status": "Finished",
      "created": "2018-02-12 14:49:37"
    },
    {
      "id": 2069,
      "name": "Test List 2",
      "description": null,
      "status": "Finished",
      "created": "2018-02-12 10:46:31"
    }
  ],
  "errors": [],
  "response": {
    "code": 200,
    "description": "OK",
    "date": "2018-02-14 15:44:10"
  },
  "api": {
    "version": "v1",
    "module": "lists",
    "function": "getall"
  },
  "user": {
    "id": 64
  }
}
```

## PHONE NUMBERS

#### Add a number to list

```php
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

Result:

{
  "success": true,
  "data": {
    "id": 31014558,
    "number": "61449980000",
    "number_normalized": "61449980000",
    "list_id": 2070,
    "country_id": 13,
    "country_name": "Australia",
    "created": "2018-02-14 15:53:00",
    "status": "good"
  },
  "errors": [],
  "response": {
    "code": 200,
    "description": "OK",
    "date": "2018-02-14 15:53:00"
  },
  "api": {
    "version": "v1",
    "module": "numbers",
    "function": "create"
  },
  "user": {
    "id": 64
  }
}
```

#### Delete a number

```php
// Params details:

// Required params:
// ids, Comma-separated IDs of numbers to be deleted

$delete_numbers_array = [
    'ids' => '1,32,27',
];

$delete_numbers = $sms_edge_api->deleteNumber($delete_numbers_array);

Result:

{
  "success": true,
  "data": {
    "message": "1 number(s) have been deleted successfully"
  },
  "errors": [],
  "response": {
    "code": 200,
    "description": "OK",
    "date": "2018-02-14 16:11:07"
  },
  "api": {
    "version": "v1",
    "module": "numbers",
    "function": "delete"
  },
  "user": {
    "id": 64
  }
}
```

#### Get numbers

```php
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

Result:

{
  "success": true,
  "data": [
    {
      "id": 31012550,
      "number": "9093190000",
      "number_normalized": "19093190000",
      "list_id": 2065,
      "country_id": 226,
      "country_name": "United States",
      "created": "2018-02-11 10:25:20",
      "created_via_api": true,
      "status": "bad"
    },
    {
      "id": 31012551,
      "number": "9093190000",
      "number_normalized": "19093190000",
      "list_id": 2065,
      "country_id": 226,
      "country_name": "United States",
      "created": "2018-02-11 10:25:26",
      "created_via_api": true,
      "status": "bad"
    }
  ],
  "errors": [],
  "pagination": {
    "limit": 2,
    "offset": 0,
    "total": 46
  },
  "response": {
    "code": 200,
    "description": "OK",
    "date": "2018-02-14 15:59:35"
  },
  "api": {
    "version": "v1",
    "module": "numbers",
    "function": "get"
  },
  "user": {
    "id": 64
  }
}
```

#### Get unsubscribers

```php
$unsubscribers = $sms_edge_api->getUnsubscribers();

Result:

{
  "success": true,
  "data": [
    {
      "number": 123456789012,
      "unsubscribed": "2018-04-10 14:33:27"
    },
    {
      "number": 123456789013,
      "unsubscribed": "2018-04-10 15:51:08"
    },
    {
      "number": 123456789014,
      "unsubscribed": "2018-04-15 10:36:39"
    }
  ],
  "errors": [],
  "response": {
    "code": 200,
    "description": "OK",
    "date": "2018-04-15 11:37:24"
  },
  "api": {
    "version": "v1",
    "module": "numbers",
    "function": "unsubscribers"
  },
  "user": {
    "id": 278
  }
}
```

## ROUTES

#### Get all routes

```php
$routes = $sms_edge_api->getRoutes();

Result: 

{
  "success": true,
  "data": [
    {
      "id": "119",
      "name": "Route 121",
      "country_id": "13",
      "country_name": "Australia",
      "price": 0.033
    },
    {
      "id": "119",
      "name": "Route 121",
      "country_id": "226",
      "country_name": "United States",
      "price": 0.012
    }
  ],
  "errors": [],
  "response": {
    "code": 200,
    "description": "OK",
    "date": "2018-03-20 12:16:59"
  },
  "api": {
    "version": "v1",
    "module": "routes",
    "function": "getall"
  },
  "user": {
    "id": 64
  }
}
```

## AUXILIARY TOOLS

#### Number Simple Verification

```php
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

Result:

{
  "success": true,
  "data": {
    "normalized_number": "61411390000",
    "national_number": "411390000",
    "country_id": 13,
    "country_name": "Australia"
  },
  "errors": [],
  "response": {
    "code": 200,
    "description": "OK",
    "date": "2018-02-12 14:04:49"
  },
  "api": {
    "version": "v1",
    "module": "verify",
    "function": "number-simple"
  },
  "user": {
    "id": 64
  }
}
```

#### Number HLR Verification

```php
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

Result: 

{
  "success": true,
  "data": {
    "normalized_number": "4799900000",
    "national_number": "99900000",
    "country_id": 160,
    "country_name": "Norway",
    "hlr": {
      "status": "bad",
      "operator": "",
      "raw_response": {
        "error": 0,
        "errorDescription": "No errors",
        "id": "470400000",
        "brand": "",
        "brand_name": "",
        "reference": "l4799900000",
        "msisdn": 4799900000,
        "network": "",
        "status": "failed",
        "details": {
          "imsi": "",
          "ported": 0
        }
      },
      "stage": "finished"
    }
  },
  "errors": [],
  "response": {
    "code": 200,
    "description": "OK",
    "date": "2018-02-14 13:32:13"
  },
  "api": {
    "version": "v1",
    "module": "verify",
    "function": "number-hlr"
  },
  "user": {
    "id": 64
  }
}
```

#### Text Analyzing

```php
// Params details:

// Required params:
// text, Text of SMS you want to verify before sending

$text_analyze_array = [
    'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
];

$text_analyze = $sms_edge_api->textAnalyzing($text_analyze_array);

Result:

{
  "success": true,
  "data": {
    "text": "My SMS text can be verified using this function. Please visit http://smsedge.io/",
    "encoding": "GSM_7BIT",
    "current_length": 80,
    "max_length": 160,
    "messages_number": 1,
    "url_detected": true,
    "urls": [
      "http://smsedge.io/"
    ]
  },
  "errors": [],
  "response": {
    "code": 200,
    "description": "OK",
    "date": "2018-02-14 13:26:31"
  },
  "api": {
    "version": "v1",
    "module": "text",
    "function": "analyze"
  },
  "user": {
    "id": 64
  }
}
```

## REPORTS

#### Sending Process Report

```php
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

Result:

{
  "success": true,
  "data": [
    {
      "id": 19581,
      "created": "2018-02-12 15:27:21",
      "from": "smsapi",
      "to": 6598800000,
      "country_id": 192,
      "country_name": "Singapore",
      "verify_local": 0,
      "shorten_url": 1,
      "list_id": 154,
      "parts": 1,
      "reference": null,
      "clicked": false,
      "cost": 0.0135,
      "original_url": "http://page.com/",
      "shortened_url": "http://sho.rt/1ei",
      "text": "Joe, visit http://sho.rt/1ei",
      "status": "sent"
    },
    {
      "id": 19580,
      "created": "2018-02-12 15:29:21",
      "from": "smsapi",
      "to": 6598795001,
      "country_id": 192,
      "country_name": "Singapore",
      "verify_local": 0,
      "shorten_url": 1,
      "list_id": 154,
      "parts": 1,
      "reference": null,
      "clicked": false,
      "cost": 0.0135,
      "original_url": "http://page.com/",
      "shortened_url": "http://sho.rt/1ei",
      "text": "Ann, visit http://sho.rt/1ei",
      "status": "waiting"
    }
  ],
  "errors": [],
  "pagination": {
    "limit": 2,
    "offset": 10,
    "total": 750
  },
  "response": {
    "code": 200,
    "description": "OK",
    "date": "2018-02-14 13:14:55"
  },
  "api": {
    "version": "v1",
    "module": "reports",
    "function": "sending"
  },
  "user": {
    "id": 64
  }
}
```

#### Statistics

```php
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

Result:

{
    "success": true,
    "data": {
        "clicks": 0,
        "sent": 5,
        "ctr": 0,
        "cost": 0.06
    },
    "errors": [],
    "response": {
        "code": 200,
        "description": "OK",
        "date": "2019-07-11 10:33:02"
    },
    "api": {
        "version": "v1",
        "module": "reports",
        "function": "stats"
    },
    "user": {
        "id": 1000
    }
}
```

## USER

#### User Details

```php
$user = $sms_edge_api->getUserDetails();

Result:

{
  "success": true,
  "data": {
    "id": 64,
    "username": "api-client",
    "email": "api-client@smsedge.io",
    "balance": "191.721",
    "registered": "2017-04-26 14:46:33",
    "optout_link": "https://goo.gl/6KsQT7"
  },
  "errors": [],
  "response": {
    "code": 200,
    "description": "OK",
    "date": "2018-02-14 13:06:36"
  },
  "api": {
    "version": "v1",
    "module": "user",
    "function": "details"
  },
  "user": {
    "id": 64
  }
}
```

## REFERENCES

#### Getting all available API functions

```php
$available_function = $sms_edge_api->getFunctions();

Result:

{
  "success": true,
  "data": [
    {
      "module": "lists",
      "function": "create",
      "url": "/v1/lists/create/"
    },
    {
      "module": "numbers",
      "function": "create",
      "url": "/v1/numbers/create/"
    },
    {
      "module": "sms",
      "function": "send-single",
      "url": "/v1/sms/send-single/"
    }
  ],
  "errors": [],
  "response": {
    "code": 200,
    "description": "OK",
    "date": "2018-02-14 13:04:25"
  },
  "api": {
    "version": "v1",
    "module": "references",
    "function": "functions"
  },
  "user": {
    "id": 9
  }
}
```

#### Getting all HTTP response status codes

```php
$http_statues = $sms_edge_api->getHttpStatuses();

Result:

{
  "success": true,
  "data": [
    {
      "code": 200,
      "description": "OK"
    },
    {
      "code": 401,
      "description": "Authentication Failure"
    },
    {
      "code": 404,
      "description": "Resource Not Found"
    }
  ],
  "errors": [],
  "response": {
    "code": 200,
    "description": "OK",
    "date": "2018-02-14 13:00:42"
  },
  "api": {
    "version": "v1",
    "module": "references",
    "function": "statuses"
  },
  "user": {
    "id": 9
  }
}
```
#### Getting list of countries
```php
$countries = $sms_edge_api->getCountries();

Result:

{
  "success": true,
  "data": [
    {
      "id": 44,
      "code_iso_aplha_2": "CN",
      "code_iso_aplha_3": "CHN",
      "code_phone": 86,
      "name": "China"
    },
    {
      "id": 226,
      "code_iso_aplha_2": "US",
      "code_iso_aplha_3": "USA",
      "code_phone": 1,
      "name": "United States"
    }
  ],
  "errors": [],
  "response": {
    "code": 200,
    "description": "OK",
    "date": "2018-02-14 12:57:07"
  },
  "api": {
    "version": "v1",
    "module": "references",
    "function": "countries"
  },
  "user": {
    "id": 152
  }
}
```





