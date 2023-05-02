
<?php

class Database
{
    public $db;

    public function getConnection()
    {
        $this->db = null;
        try {
            $this->db = new PDO("mysql:host=localhost;dbname=familytree", "root", "");
        } catch (Exception $e) {
            echo "Database could not be connected: " . $e->getMessage();
        }
        return $this->db;
    }
}

?>