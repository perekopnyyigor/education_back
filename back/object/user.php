<?php
require_once "database.php";
class User
{
    public $id;
    public $name;
    public $email;
    public $myCours;
    public $subscribCours;
    public $lesson;

    static function add($user_json)
    {

        $user=json_decode($user_json);
        $database = new Database();

        $database->connect();


        if ($user->pass1 != $user->pass2)
            $result = "Пароли не совпадают";
        else if($user->name==null || $user->pass1==null || $user->pass2==null || $user->email==null)
            $result = "Не все поля заполнены";
        else if ($database->select("id","user","WHERE name =".$user->name)!=null)
        {
            $result = "Пользователь с таким именем уже зарегистрирован";
        }
        else
        {
            $password = md5($user->pass1);
            $sql = "INSERT INTO user (name, email, password) VALUES ('".$user->name."', '".$user->email."', '".$password."')";
            $result = $database->conn->query($sql);
            // Check
            if ($database->conn->error)
            {
                die("failed: " . $database->conn->error);
            }
            $result = "Пользователь зарегистрирован";
        }
        return $result;

    }
    static function enter($user_json)
    {
        $database = new Database();


        $user=json_decode($user_json);
        $password = $database->select_one("password","user","WHERE name ='".$user->name."'");
        if(md5($user->pass1)==$password)
        {
            $id = $database->select_one("id","user","WHERE name ='".$user->name."'");
            $user = new User($id);
            return json_encode($user);
        }

    }
    function __construct($id)
    {
        $database = new Database();
        $this->id=$id;
        $this->name=$database->select_one("name","user","WHERE id ='".$id."'");
        $this->email=$database->select_one("email","user","WHERE id ='".$id."'");
        $this->myCours=$database->select("id","cours","WHERE user ='".$this->id."'");
        $this->subscribCours=$database->select("cours","subscrib","WHERE user ='".$this->id."'");
        $this->lesson=$database->select("article","lesson","WHERE user=".$this->id);
    }

    function subscrib($id)
    {
        $database = new Database();

        $check=$database->select_one("id","subscrib","WHERE cours ='".$id."' AND user='".$this->id."'");

        if(!isset($check))
        {
            $database->connect();
            $sql = "INSERT INTO subscrib (cours, user) VALUES ('".$id."','".$this->id."')";

            $result = $database->conn->query($sql);
            echo $database->conn->error;
            if ($database->conn->error)
            {
                die("failed: " . $database->conn->error);

            }

            $database->conn->close();
            $result = "Курс добавлен в избранные";
        }
        else
        {
            $result = "Курс уже добавлен ";
        }



        return $result;
    }
    public function addLesson($article)
    {

        $datadase = new Database();



        $check = $datadase->select_one("id","lesson","WHERE user=".$this->id." AND article = ".$article);

        if (isset($check))
        {
            $count = $datadase->select_one("count","lesson","WHERE user=".$this->id." AND article = ".$article);
            $count++;
            $datadase->connect();
            $sql ="UPDATE lesson SET count ='".$count."', date=NOW() WHERE user=".$this->id." AND article = ".$article;
        }
        else
        {
            $datadase->connect();
            $sql = "INSERT INTO lesson (user, article, count ) VALUES ('".$this->id."', '".$article."',1)";
        }


        $result = $datadase->conn->query($sql);
        // Check1
        if ($datadase->conn->error)
        {
            echo $datadase->conn->error;

        }
        else
            echo "Повтор учтeн";

    }
    public function addRepeat($article)
    {
        $datadase = new Database();
        $datadase->connect();


        //$lesson_id = $datadase->select_one("id","lesson","WHERE user=".$this->id." AND article = ".$article);
        //$datadase->connect();
        $sql = "INSERT INTO repeat_ (user, article ) VALUES ('".$this->id."', '".$article."')";



        $result = $datadase->conn->query($sql);
        // Check1
        if ($datadase->conn->error)
        {
            echo $datadase->conn->error;

        }
        else
            echo "Повтор учтeн";
    }
    public function getLessonArticle()
    {

    }

}
