<?php

define('API_PATH',      '/api/');
define('TOTAL_URLS',    10);
// define('CRONJOB_TIME',  86400); // 1 day
define('CRONJOB_TIME',  2 * 60); // 5 minutes
define('CRONJOB_FILE',  'cronjob-last-part.txt');
define('START_TIME',    mktime(5, 40, 0, 6, 22, 2022));
