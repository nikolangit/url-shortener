<?php

class Database
{

    private $host   = 'localhost';
    private $user   = 'root';
    private $pswd   = '';
    private $name   = 'url_shortener';
    private $prefix = '';

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

    public function query(string $sql, array $binds = [])
    {
        $this->stmt = $this->con->prepare($sql);
        foreach ($binds as $fieldName => $fieldValue) {
            $this->stmt->bindValue(':' . $fieldName, $fieldValue, $this->bind_type($fieldValue));
        }
        $this->exec = $this->stmt->execute();

        return $this;
    }

    public function get()
    {
        $ret = [];

        if ($this->exec) {
            $ret = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        $this->close();

        return $ret;
    }

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

    private function close()
    {
        $this->con  = null;
        $this->stmt = null;
        $this->exec = false;
    }

}
