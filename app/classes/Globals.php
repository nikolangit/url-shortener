<?php

/**
 * Globals handler.
 *
 * It handles global methods and functions.
 *
 * @copyright  Copyright (©) 2022 (https://nikolangit.github.io/)
 * @author     Nikola Nikolić <rogers94@gmail.com>
 * @link       https://nikolangit.github.io/
 */
class Globals
{

    /**
     * It returns the default response.
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @return array Default response.
     */
    public static function getResponseArr()
    {
        $ret = [
            'error' => '',
            'url'   => '',
            'hash'  => '',
        ];

        $ret = array_merge(
            $ret,
            self::prepareUrlsAndTimerData()
        );

        return $ret;
    }

    /**
     * It gets cronjob's time part value.
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @return integer Cronjob's time part.
     */
    public static function getCronjobPart()
    {
        return (int)file_get_contents(CRONJOB_FILE);
    }

    /**
     * It set new value to the cronjob's time part.
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @param  integer $newCronjobTimePart New cronjob time part.
     * @return boolean                     Status of saving file.
     */
    public static function setCronjobPart(int $newCronjobTimePart)
    {
        return file_put_contents(CRONJOB_FILE, $newCronjobTimePart);
    }

    /**
     * It formats number to time format with leading zero's.
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @param  integer $time Time in seconds.
     * @return string        Formated time.
     */
    public static function timeFormat(int $time)
    {
        $hours   = floor($time / 3600);
        $minutes = floor(($time - ($hours * 3600)) / 60);
        $seconds = $time - ($hours * 3600) - ($minutes * 60);

        if ($hours < 10) {
            $hours = '0' . $hours;
        }

        if ($minutes < 10) {
            $minutes = '0' . $minutes;
        }

        if ($seconds < 10) {
            $seconds = '0' . $seconds;
        }

        return "{$hours}:{$minutes}:{$seconds}";
    }

    /**
     * It returns prepared data of total URL in a database and timer data.
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @return array Prepared URL and timer data.
     */
    public static function prepareUrlsAndTimerData()
    {
        $ret = [
            'urls' => [
                'total'     => 0,
                'remaining' => 0,
            ],
            'timer' => [
                'number'   => 0,
                'formated' => '',
            ],
        ];

        // Get total rows.
        $totalRows = Hash::getTotalRows();

        // Get cronjob time part.
        $cronjobTimePart = self::getCronjobPart();

        // Prepare values for setting cronjob's time part.
        $currentTime     = time();
        $diffTime        = $currentTime - CRONJOB_START_TIME;
        $timeDiffParts   = ceil($diffTime / CRONJOB_TIME);
        $nextCronjobTime = CRONJOB_START_TIME + (CRONJOB_TIME * $timeDiffParts);

        if ($totalRows > TOTAL_URLS) {
            $totalRows = 0;
        }

        if ($cronjobTimePart < $timeDiffParts) {
            Hash::truncate();

            $totalRows = 0;

            self::setCronjobPart($timeDiffParts);
        }

        // Update response data.
        $ret['urls']['total']     = $totalRows;
        $ret['urls']['remaining'] = TOTAL_URLS - $totalRows;

        $ret['timer']['number']   = $nextCronjobTime - $currentTime;
        $ret['timer']['formated'] = self::timeFormat($ret['timer']['number']);

        return $ret;
    }

}
