<?php
require_once "database.php";
require_once "article.php";
class Lesson
{
    public $user;
    public $article_id;
    public $lastDate;
    public $count;
    public $allDate;
    public $article;
    public $days;
    public function __construct($user,$article_id)
    {
        $datadase = new Database();
        $this->user=$user;
        $this->article_id =$article_id;
        $this->lastDate = $datadase->select_one("date","lesson","WHERE user=".$user." AND article = ".$article_id);

        $now = time(); // текущее время (метка времени)
        $your_date = strtotime($this->lastDate); // какая-то дата в строке (1 января 2017 года)
        $this->days = ($now - $your_date)/(60*60*24); // получим разность дат (в секундах)

        $this->count = $datadase->select_one("count","lesson","WHERE user=".$user." AND article = ".$article_id);
        $this->allDate=$datadase->select("date","repeat_","WHERE user=".$user." AND article = ".$article_id);
        $this->article = new Article($article_id,false);
    }


}
