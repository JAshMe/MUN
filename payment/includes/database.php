<?php
/**
 * Created by PhpStorm.
 * User: JAshMe
 * Date: 3/8/2018
 * Time: 3:35 PM
 */

//Class for database functions
class PDOdb
{
        var $host;
        var $db;
        var $user;
        var $pass;
        var $charset;
        var $pdo;

        //Connecting to database
        function __construct($db)
        {
                $this->host = '127.0.0.1';
                $this->user = 'root';
                $this->pass = '';
                $this->charset = 'utf8mb4';
                $this->opt = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                ];
                $this->db = $db;
                $dsn = "mysql:host=".$this->host.";dbname=".$this->db.";charset=".$this->charset.";";
                $this->pdo =  new PDO($dsn, $this->user, $this->pass, $this->opt);

        }

        function select_query($prepared, $param)
        {
               $stmt = $this->pdo->prepare($prepared);
                $stmt->execute($param);

                return $stmt;
        }

        function ins_del_query($prepared,$param)
        {
                $this->pdo->prepare($prepared)->execute($param);
                return;
        }
}