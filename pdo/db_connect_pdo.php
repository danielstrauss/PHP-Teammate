<?php
    class dbconnect{
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $charset;


    public function funcDbConnect(){
        $this->servername ="localhost";
        $this->username ="mysql_user";
        $this->password ="hOLuVixuQOqi6u3i8a7On4k4qOTi6O";
        $this->dbname="mysql";
        $this->charset="utf8mb4";
/*
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        return $conn;
  */      
        // PDO
        try {
            $dsn = "mysql:host=".$this->servername.";dbname=".$this->dbname.";charset=".$this->charset."";
            $pdo = new PDO($dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;

        }catch (PDOExcetption $e){
            echo "Connection failed: " . $e->getMessage();
        }
        
        
    }



}
?>