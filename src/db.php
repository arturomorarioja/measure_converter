<?php
/**
 * Encapsulates a connection to the database 
 * 
 * @author  Arturo Mora-Rioja
 * @version 1.0 August 2020
 */
    class DB {
        const HOST = 'localhost';
        const NAME = 'converter';
        const USER = 'root';
        const PWD = '';

        protected $pdo;

        /**
         * Opens a connection to the database
         */
        public function __construct() {
            $dsn = 'mysql:host=' . DB::HOST . ';dbname=' . DB::NAME . ';charset=utf8';
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];

            try {
                $this->pdo = @new PDO($dsn, DB::USER, DB::PWD, $options); 
            } catch (\PDOException $e) {
                echo 'Connection unsuccessful';
                die('Connection unsuccessful: ' . $e->getMessage());
                exit();
            }
        }

        /**
         * Closes a connection to the database
         */
        public function disconnect() {
            $this->pdo = null;
        }
    }
?>