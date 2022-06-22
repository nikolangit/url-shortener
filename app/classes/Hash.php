<?php

class Hash
{

    private static function generate(int $totalRows = 0)
    {
        return dechex(
            crc32(
                md5($totalRows + 1)
            )
        );
    }

    public static function get(string $hash)
    {
        $database = new Database;

        $sql = "SELECT hash,url,hits FROM urls WHERE hash='$hash';";
        $ret = $database->query($sql)
            ->first()
        ;

        return $ret;
    }

    public static function save(string $url)
    {
        $response = Globals::getResponseArr();

        $hash = self::generate($response['urls']['total'] + 1);
        $date = date('Y-m-d H:i:s');

        $database = new Database;

        $sql = "INSERT INTO `urls`(
                `hash`,
                `url`,
                `created_at`
            ) VALUES (
                '$hash',
                '$url',
                '$date'
            );";
        $query = $database->query($sql)->first();

        $hashData = self::get($hash);

        $response = array_merge(
            $response,
            $hashData
        );

        return $response;
    }

    public static function truncate()
    {
        $database = new Database;

        $sql = 'TRUNCATE urls';
        $ret = $database->query($sql)
            ->first()
        ;

        return $ret;
    }

    public static function update(string $hash)
    {
        $database = new Database;

        $sql = "UPDATE `urls` SET `hits`=`hits` + 1 WHERE hash='$hash'";
        $ret = $database->query($sql)
            ->first()
        ;

        return $ret;
    }

}
