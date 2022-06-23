<?php

/**
 * ___ handler.
 *
 * It handles ___ methods and functions.
 *
 * @copyright  Copyright (©) 2022 (https://nikolangit.github.io/)
 * @author     Nikola Nikolić <rogers94@gmail.com>
 * @link       https://nikolangit.github.io/
 */
class Database
{

    // Database configuration.
    private $host = 'localhost';
    private $user = 'root';
    private $pswd = '';
    private $name = 'url_shortener';

    private $con;
    private $stmt;
    private $exec;

    public function __construct()
    {
        $this->con = new PDO(
            'mysql:host=' . $this->host . ';dbname=' . $this->name,
            $this->user,
            $this->pswd,
            [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE    => PDO::ERRMODE_EXCEPTION,
            ]
        );
    }

    /**
     * It returns data type of value for PDO.
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @param  mixed $value Value to check the data type.
     * @return mixed        Data type as PDO constant.
     */
    private function bind_type($value)
    {
        $ret = PDO::PARAM_NULL;
        if (is_int($value)) {
            $ret = PDO::PARAM_INT;
        } else if (is_bool($value)) {
            $ret = PDO::PARAM_BOOL;
        } else if (is_string($value)) {
            $ret = PDO::PARAM_STR;
        }

        return $ret;
    }

    /**
     * Prepared query to be executed.
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @param  string $sql   SQL query.
     * @param  array  $binds Parameters to bind.
     * @return
     */
    public function query(string $sql, array $binds = [])
    {
        $this->stmt = $this->con->prepare($sql);
        foreach ($binds as $fieldName => $fieldValue) {
            $this->stmt->bindValue(':' . $fieldName, $fieldValue, $this->bind_type($fieldValue));
        }
        $this->exec = $this->stmt->execute();

        return $this;
    }

    /**
     * It returns all records from the table.
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @return json
     */
    public function get()
    {
        $ret = [];

        if ($this->exec) {
            $ret = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        $this->close();

        return $ret;
    }

    /**
     * It returns first record from the table.
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @return json
     */
    public function first()
    {
        $ret = [];

        if ($this->exec) {
            $ret = $this->stmt->fetch(PDO::FETCH_ASSOC);
            if (!is_array($ret)) {
                $ret = [];
            }
        }

        $this->close();

        return $ret;
    }

    /**
     * It closes the PDO connection.
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @return void
     */
    private function close()
    {
        $this->con  = null;
        $this->stmt = null;
        $this->exec = false;
    }

}
