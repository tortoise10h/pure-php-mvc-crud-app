<?php
    /*
        * PDO database class
        * Connect to database
        * Create prepare statement
        * Bind values
        * Return row & result
    */
    class Database{
        private $host = DB_HOST;
        private $user = DB_USER;
        private $pass = DB_PASS;
        private $dbname = DB_NAME;

        private $pdo;
        private $stmt;
        private $error;
        
        public function __construct(){
            //create DSN
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            
            //create pdo instance
            try{   
                $this->pdo = new PDO($dsn,$this->user,$this->pass,$options);
            }catch(PDOException $e){
                $this->error = $e->getMessage();
                echo $this->error . '<br>';
            }
        }

        //Prepare statement with query
        public function query($sql){
            $this->stmt = $this->pdo->prepare($sql);
        }
        //Bind value to prepare statement
        public function bind($param,$value,$type = null){
            if(is_null($type)){
                switch(true){
                    case is_int($value):{
                        $type = PDO::PARAM_INT;
                        break;
                    }
                    case is_bool($value):{
                        $type = PDO::PARAM_BOOL;
                        break;
                    }
                    case is_null($value):{
                        $type = PDO::PARAM_NULL;
                        break;
                    }
                    default:{
                        $type = PDO::PARAM_STR;
                    }
                }
            }

            $this->stmt->bindValue($param,$value,$type);
        }
        //Execute prepare statement
        public function execute(){
            return $this->stmt->execute();
        }
        //Get result set as array of object
        public function resultSet(){
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }
        //Get single record as object
        public function singleResult(){
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }
        //Get row count
        public function rowCount(){
            return $this->stmt->rowCount();
        }
    }
?>