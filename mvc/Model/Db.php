<?php
class Db {
	public $user = 'olia';
	public $password = '1234';
	public $dns = 'mysql:host=localhost; dbname=shortener';

    public function getConnection() {
        $connectionDb = new PDO($this->dns, $this->user, $this->password);
        $connectionDb->exec("set names utf8");
        return $connectionDb;
    }
}