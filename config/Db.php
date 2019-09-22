<?php
namespace Config;

use Exception;

class Db {
    
    public $conn;

    public function getConnection($host, $user, $password, $db_name) {
        
        $this->conn = null;
        
        try {
            
            $this->conn = new \PDO(
                'mysql:host=' . $host . ';dbname=' . $db_name,
                $user,
                $password
            );
            
        } catch(Exception $e) {
            
            throw new Exception(
                '<b>PDO connection error:</b> ' . $e->getMessage()
            );
            
        }

        $this->conn->exec('SET CHARACTER SET utf8');
        $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        
        return $this->conn;
        
    }
    
}