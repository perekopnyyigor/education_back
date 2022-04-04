<?php
require_once "database.php";
class Chapter
{
    public $id;
    public $name;
    public $cours;
    public $articlesId=[];
    public $articles;

    static function add($chapter_json)
    {

        $chapter=json_decode($chapter_json);
        $database = new Database();
        $database->connect();

        $sql = "INSERT INTO chapter (name,cours) VALUES ('".$chapter->name."','".$chapter->cours."')";
        $result = $database->conn->query($sql);
        // Check
        if ($database->conn->error)
        {
            die("failed: " . $database->conn->error);
        }
        $result = "Глава добавлена";
        $database->conn->close();
        return $result;

    }
    public function __construct($id)
    {
        $database = new Database();
        $this->id=$id;
        $this->name=$database->select_one("name","chapter","WHERE id ='".$id."'");
        $this->cours=$database->select_one("cours","chapter","WHERE id ='".$id."'");
        $this->articlesId=$database->select("id","article","WHERE chapter ='".$id."'");
    }


}

