<?php
require_once "database.php";
class Article
{
    public $id;
    public $name;
    public $text;
    public $chapter;
    public $cours;

    public $description;
    public $keyword;
    public $img;

    static function add($article_json)
    {

        $article=json_decode($article_json);
        $database = new Database();
        $database->connect();

        $sql = "INSERT INTO article (name,chapter) VALUES ('".$article->name."','".$article->chapter_id."')";
        $result = $database->conn->query($sql);
        // Check
        if ($database->conn->error)
        {
            die("failed: " . $database->conn->error);
        }
        $result = "Cтатья добавлена";
        $database->conn->close();
        return $result;

    }
    public static function save($article_json)
    {
        $article=json_decode($article_json);
        $datadase = new Database();
        $text = str_replace("\\","s_l_a_s_h",$article->text);
        $datadase->connect();

        $sql ="UPDATE article SET text ='".$text."' WHERE id=".$article->id;


        $result = $datadase->conn->query($sql);
        // Check1
        if ($datadase->conn->error)
        {
            echo $datadase->conn->error;
        }
        $datadase->conn->close();
        return "Статья обновлена";
    }

    public static function saveOptions($article_json)
    {
        $article=json_decode($article_json);
        $datadase = new Database();

        $datadase->connect();

        $sql ="UPDATE article SET name ='".$article->name."', description ='".$article->description."', keyword ='".$article->keyword."' WHERE id=".$article->id;

        $result = $datadase->conn->query($sql);
        // Check1
        if ($datadase->conn->error)
        {
            echo $datadase->conn->error;
        }
        $datadase->conn->close();
        Article::uploadMainImg($article->name,$article->id);
        return "Свойства изменены".$article->id;
    }
    public function __construct($id,$show_text)
    {
        $database = new Database();
        $this->id=$id;
        $this->name=$database->select_one("name","article","WHERE id ='".$id."'");
        $this->description=$database->select_one("description","article","WHERE id ='".$id."'");
        $this->keyword=$database->select_one("keyword","article","WHERE id ='".$id."'");
        $this->img=$database->select_one("img","article","WHERE id ='".$id."'");

        if($show_text)
        {
            $text=$database->select_one("text","article","WHERE id ='".$id."'");
            $this->text = str_replace("s_l_a_s_h","\\",$text);
        }


        $this->chapter=$database->select_one("chapter","article","WHERE id ='".$id."'");
        $this->cours=$database->select_one("cours","chapter","WHERE id ='".$this->chapter."'");
    }
    public function uploadImg()
    {
        if(isset($_FILES["file"]))
        {
            $tmp_name = $_FILES["file"]["tmp_name"][0];

            $name_img = basename($_FILES["file"]["name"][0]);
            $name =str_replace(" ", "-",$this->name);
            $name_img = $name."-".$this->cours."-".$name_img;
            $path=$_SERVER['DOCUMENT_ROOT']."/img/".$name_img;

            if(move_uploaded_file($tmp_name, $path))
            {
                //$source = imagecreatefrompng($path);
                //imagejpeg($source, $path, 100);
                echo "файл был загружен";
            }

            else {
                echo "загрузка не удалась";
            }


        }
        else
        {
            echo "загрузка не удалась1";
        }
        echo $name_img;

        $file = "<img src=\"https://tiwy.ru/img/".$name_img."\">";

        $datadase = new Database();
        $datadase->connect();
        $sql ="UPDATE article SET text ='".$this->text.$file."' WHERE id=".$this->id;
        $result = $datadase->conn->query($sql);
        // Check1
        if ($datadase->conn->error)
        {
            echo $datadase->conn->error;
        }
        $datadase->conn->close();

    }
    static function uploadMainImg($article_name, $article_id)
    {
        if(isset($_FILES["file"]))
        {
            $tmp_name = $_FILES["file"]["tmp_name"][0];

            $name_img = basename($_FILES["file"]["name"][0]);
            $name =str_replace(" ", "-",$article_name);
            $name_img = $name."-".$name_img;
            $path=$_SERVER['DOCUMENT_ROOT']."/img/".$name_img;

            if(move_uploaded_file($tmp_name, $path))
            {
                //$source = imagecreatefrompng($path);
                //imagejpeg($source, $path, 100);

                $file ="img/".$name_img;

                $datadase = new Database();
                $datadase->connect();
                $sql ="UPDATE article SET img ='".$file."' WHERE id=".$article_id;
                $result = $datadase->conn->query($sql);
                // Check1
                if ($datadase->conn->error)
                {
                    echo $datadase->conn->error;
                }
                $datadase->conn->close();


                echo "файл был загружен";
            }

            else {
                echo "загрузка не удалась";
            }


        }
        else
        {
            echo "загрузка не удалась1";
        }
        echo $name_img;


    }
    static function findArticle()
    {
        $database = new Database();
        return $database->select("id","article","WHERE img IS NOT NULL");
    }



}


