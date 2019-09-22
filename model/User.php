<?php
namespace UserApp;

Use Exception;
Use DateTime;

class User {
 
    private $conn;
    private $char_limit;
    private $genders;
 
    public $id;
    public $name;
    public $email;
    public $birthdate;
    public $gender;
 
    public function __construct($conn){
        
        $this->conn = $conn;
        
        $this->char_limit = [
            'name' => 100,
            'email' => 50
        ];
        
        $this->genders = ['m', 'f', 'o'];
        
    }
    
    private function sanitize(&$string) {
        $string = trim(strip_tags($string));
    }
    
    private function validate(&$value, $field) {
        
        $this->sanitize($value);
        
        switch ($field) {
            
            case 'name':
            case 'email':
            
                if (strlen($value) > $this->char_limit[$field]) {
                    throw new Exception('The value for the field "' . $field . '" exceeds the maximum length of ' . $this->char_limit[$field] . '.');
                }
                
                if ($field == 'email') {
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        throw new Exception('Invalid email address.');
                    }
                }
                
            break;
            
            case 'birthdate':
                
                $value = str_replace('/', '-', $value);
                
                if (date('Y-m-d', strtotime($value)) != $value) {
                    throw new Exception('Invalid date or date format (please use YYYY-MM-DD).');
                }
                
            break;
            
            case 'gender':
                
                if (!in_array($value, $this->genders)) {
                    throw new Exception('Invalid gender specification (please use "m" for male, "f" for female, or "o" for other).');
                }
            
            break;
            
        }
        
    }
    
    public function getSingle() {
        
        $sth = $this->conn->prepare(
            'SELECT *
            FROM user
            WHERE id = :id;'
        );
        
        $sth->bindParam(':id', $this->id, \PDO::PARAM_INT);
        $sth->execute();
        
        return $sth->fetch(\PDO::FETCH_OBJ);
        
    }
    
    public function getAll() {
        
        $sth = $this->conn->prepare(
            'SELECT *
            FROM user;'
        );
        
        $sth->execute();
        
        return $sth->fetchAll(\PDO::FETCH_OBJ);
        
    }
    
    public function create() {
        
        $sth = $this->conn->prepare(
            'INSERT INTO user
            SET name = :name,
            email = :email,
            birthdate = :birthdate,
            gender = :gender;'
        );
        
        try {
            
            $this->validate($this->name, 'name');
            $this->validate($this->email, 'email');
            $this->validate($this->birthdate, 'birthdate');
            $this->validate($this->gender, 'gender');
            
        } catch(Exception $e) {
            return $e->getMessage();
        }
        
        $sth->bindParam(":name", $this->name, \PDO::PARAM_STR);
        $sth->bindParam(":email", $this->email, \PDO::PARAM_STR);
        $sth->bindParam(":birthdate", $this->birthdate, \PDO::PARAM_STR);
        $sth->bindParam(":gender", $this->gender, \PDO::PARAM_STR);
     
        if ($sth->execute()) {
            
            return $this->conn->lastInsertId();
            
        } else {
            
            return false;
            
        }
        
    }
    
    public function update() {
        
        $sth = $this->conn->prepare(
            'UPDATE user
            SET name = :name,
            email = :email,
            birthdate = :birthdate,
            gender = :gender
            WHERE id = :id;'
        );
        
        try {
            
            $this->validate($this->name, 'name');
            $this->validate($this->email, 'email');
            $this->validate($this->birthdate, 'birthdate');
            $this->validate($this->gender, 'gender');
            
        } catch(Exception $e) {
            return $e->getMessage();
        }
        
        $sth->bindParam(":name", $this->name, \PDO::PARAM_STR);
        $sth->bindParam(":email", $this->email, \PDO::PARAM_STR);
        $sth->bindParam(":birthdate", $this->birthdate, \PDO::PARAM_STR);
        $sth->bindParam(":gender", $this->gender, \PDO::PARAM_STR);
        $sth->bindParam(":id", $this->id, \PDO::PARAM_INT);
     
        return $sth->execute();
        
    }
    
    public function delete() {
        
        $sth = $this->conn->prepare(
            'DELETE FROM user
            WHERE id = :id;'
        );
        
        $sth->bindParam(":id", $this->id, \PDO::PARAM_INT);
     
        return $sth->execute();
        
    }
    
}