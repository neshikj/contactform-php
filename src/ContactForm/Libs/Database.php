<?php

namespace ContactForm\Libs;

use PDO;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Database {

    protected $conn;
    public $isConnected = false;

    /**
     * @var Logger $logger
     */
    private $logger;

    public function __construct() {
        // Create a log channel
        $logger = new Logger('Database');
        $logger->pushHandler(new StreamHandler(__DIR__.'/../logs/db.log'));
        $this->logger = $logger;

        try{
            $this->conn = new PDO("mysql:host=".getenv('DB_HOST').";dbname=".getenv('DB_NAME'),getenv('DB_USER'),getenv('DB_PASS'));
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conn->setAttribute( PDO::ATTR_EMULATE_PREPARES, false);
            $this->isConnected = true;
        } catch(\PDOException $e){
            $this->isConnected = false;
            $this->logger->error('Database connection issue: '.$e->getMessage());
        }
    }

    public function disconnect() {
        $this->conn = null;
        $this->isConnected = false;
    }

    public function insert($query,$params){
        try{
            $st = $this->conn->prepare($query);
            $st->execute($params);
        } catch(\PDOException $e){
            $this->logger->error('Database insert issue: '.$e->getMessage());
        }
    }
}

?>