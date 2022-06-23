<?php

/**
 * Hashes handler.
 *
 * It handles hash methods and functions.
 *
 * @copyright  Copyright (©) 2022 (https://nikolangit.github.io/)
 * @author     Nikola Nikolić <rogers94@gmail.com>
 * @link       https://nikolangit.github.io/
 */
class Hash
{

    /**
     * It generates hash string.
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @param  integer $totalRows Total rows in a database.
     * @return string             Generated hash.
     */
    private static function generateHash(int $totalRows = 0)
    {
        return dechex(
            crc32(
                md5($totalRows + 1)
            )
        );
    }

    /**
     * It check's wheather the hash or URL exists in a database.
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @param  string $hash Hash.
     * @param  string $url  URL.
     * @return array        Matched rows.
     */
    private static function checkRow(string $hash, string $url)
    {
        $database = new Database;

        $sql = "SELECT hash,url,hits FROM urls WHERE hash='$hash' OR url='$url';";
        $ret = $database->query($sql)
            ->first()
        ;

        return $ret;
    }

    /**
     * It gets an hash.
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @param  string $hash Hash.
     * @return array        Hash data.
     */
    public static function get(string $hash)
    {
        $database = new Database;

        $sql = "SELECT hash,url,hits FROM urls WHERE hash='$hash';";
        $ret = $database->query($sql)
            ->first()
        ;

        return $ret;
    }

    /**
     * It saves an hash.
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @param  string $url URL to be saved.
     * @return array       Hash data.
     */
    public static function save(string $url)
    {
        $ret = Globals::getResponseArr();

        // Total rows in a database.
        $totalRows = self::getTotalRows();
        if ($totalRows > TOTAL_URLS) {
            return $ret;
        }

        $hash = self::generateHash($totalRows + 1);
        $date = date('Y-m-d H:i:s');

        // Check if hash and URL exists in a database.
        $checkRow = self::checkRow($hash, $url);
        if (!empty($checkRow)) {
            $ret['error'] = 'Requested URL already exists. Please try again.';
            return $ret;
        }

        // Database.
        $database = new Database;

        // Query.
        $sql = "INSERT INTO `urls`(
            `hash`,
            `url`,
            `created_at`
        ) VALUES (
            '$hash',
            '$url',
            '$date'
        );";
        $database->query($sql)->first();

        $hashData = Hash::get($hash);

        // Default response.
        $responseArray = Globals::getResponseArr();

        $ret = array_merge(
            $responseArray,
            $hashData
        );

        return $ret;
    }

    /**
     * It truncates the table.
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @return void
     */
    public static function truncate()
    {
        $database = new Database;

        $sql = 'TRUNCATE urls';
        $database->query($sql)
            ->first()
        ;
    }

    /**
     * It updates "hits" field in a database.
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @param  string $hash The value of hash to be updated.
     * @return array        Hash data.
     */
    public static function update(string $hash)
    {
        $database = new Database;

        $sql = "UPDATE `urls` SET `hits`=`hits` + 1 WHERE hash='$hash';";
        $ret = $database->query($sql)
            ->first()
        ;

        return $ret;
    }

    /**
     * It gets total rows from the database.
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @param  void
     * @return 
     */
    public static function getTotalRows()
    {
        $database = new Database;

        $sql = "SELECT COUNT(hash) AS total FROM urls;";
        $ret = $database->query($sql)
            ->first()
        ;

        return $ret['total'];
    }

}
