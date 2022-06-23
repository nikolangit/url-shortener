<?php

// Basic app constants.
define('API_PATH',      '/api/');
define('APP_PATH',      $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/');

// Total URL's to be saved in a database.
define('TOTAL_URLS',    512);

// Cronjob's data.
define('CRONJOB_TIME',          86400); // 1 day
define('CRONJOB_FILE',          'cronjob-part.txt');
define('CRONJOB_START_TIME',    mktime(0, 0, 0, 6, 25, 2022));
