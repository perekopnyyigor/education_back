<?php
require_once "database.php";
class Cours
{
    public $id;
    public $name;
    public $type;
    public $img;
    public $keywords;
    public $description;
    static function add($cours_json)
    {

        $cours=json_decode($cours_json);
        $database = new Database();
        $database->connect();
        $img=Cours::uploadImg($cours->user,$cours->name);
        $sql = "INSERT INTO cours (name,type,user,img) VALUES ('".$cours->name."','".$cours->type."','".$cours->user."','".$img."')";
        $result = $database->conn->query($sql);
        // Check
        if ($database->conn->error)
        {
            die("failed: " . $database->conn->error);
        }
        $result = "Курс добавлен";

        return $result;

    }
    public function __construct($id)
    {
        $database = new Database();
        $this->id=$id;
        $this->name=$database->select_one("name","cours","WHERE id ='".$id."'");
        $this->type=$database->select_one("type","cours","WHERE id ='".$id."'");
        $this->img=$database->select_one("img","cours","WHERE id ='".$id."'");
        $this->description=$database->select_one("description","cours","WHERE id ='".$id."'");
        $this->keywords=$database->select_one("keywords","cours","WHERE id ='".$id."'");
    }

    static function uploadImg($shop,$name_orig)
    {
        if(isset($_FILES["file"]))
        {

            $tmp_name = $_FILES["file"]["tmp_name"][0];

            $name_img = basename($_FILES["file"]["name"][0]);
            $name =str_replace(" ", "_",$name_orig);
            $name_img = $name."_".$shop."_".$name_img;
            $path=$_SERVER['DOCUMENT_ROOT']."/img/".$name_img;
            if(move_uploaded_file($tmp_name, $path))
            {

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

        return "img/".$name_img;
    }
    public function redact()
    {

    }
    public function findChapters()
    {
        $database = new Database();
        return $database->select("id","chapter","WHERE cours ='".$this->id."'");
    }
    public static function findCours()
    {
        $database = new Database();
        return $database->select("id","cours");
    }
    public function delete()
    {

        $database = new Database();
        $database->connect();

        $sql = "DELETE FROM cours WHERE id=".$this->id;
        $result = $database->conn->query($sql);
        // Check
        if ($database->conn->error)
        {
            die("failed: " . $database->conn->error);
            $result=$database->conn->error;
        }
        else
            $result = "Курс удален";

        return $result;
    }
    public static function saveOptions($article_json)
    {
        $article=json_decode($article_json);
        $datadase = new Database();

        $datadase->connect();

        $sql ="UPDATE cours SET name ='".$article->name."', description ='".$article->description."', keywords ='".$article->keyword."' WHERE id=".$article->id;

        $result = $datadase->conn->query($sql);
        // Check1
        if ($datadase->conn->error)
        {
            echo $datadase->conn->error;
        }
        $datadase->conn->close();
        Cours::uploadMainImg($article->name,$article->id);
        return "Свойства изменены".$article->id;
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
                $sql ="UPDATE cours SET img ='".$file."' WHERE id=".$article_id;
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
}

