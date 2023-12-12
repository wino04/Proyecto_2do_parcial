<?php
class Connection{
    private $server = 
    "mysql:host=localhost;
    dbname=switchbook";
    private $username = "tamal";
    private $password = "derajas";
    private $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);

    protected $conn;

    public function open (){
        try{
            $this->conn = new PDO
            ($this->server,
            $this->username,
            $this->password,
            $this->options);
            return $this -> conn;
        }
        catch (PDOException $e){
            echo "Actualemnet existe un problema con la conexion, espere a ser canañizado con el admin papu :V" .
            $e->getMessage();
                }

    }

    public function close(){
        $this->conn = null;
    }
}

?>