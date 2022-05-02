<?php
require_once "database.php";
class Card
{
    public $name;
    public $text;
    public $user;
    public $article;
    static function add($json_card)
    {
        $card = json_decode($json_card);

        $database = new Database();
        $database->connect();

        $sql = "INSERT INTO card (name,text,article,user) VALUES ('".$card->name."','".$card->text."','".$card->article."','".$card->user."')";
        $result = $database->conn->query($sql);
        // Check
        if ($database->conn->error)
        {
            die("failed: " . $database->conn->error);
        }
        $result = "Карта добавлена";

        return $result;
    }
    static function find($json_cards)
    {
        $cards = json_decode($json_cards);
        $database = new Database();
        return $database->select("id","card","WHERE user ='".$cards->user."' AND article='".$cards->article."' ");
    }
    public function __construct($id)
    {
        $database = new Database();
        $this->name=$database->select_one("name","card","WHERE id ='".$id."'");
        $this->text=$database->select_one("text","card","WHERE id ='".$id."'");
        $this->user=$database->select_one("user","card","WHERE id ='".$id."'");
        $this->article=$database->select_one("article","card","WHERE id ='".$id."'");
    }
}