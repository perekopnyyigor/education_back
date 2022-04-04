<?php
require_once "../object/user.php";
require_once "../object/cours.php";
require_once "../object/lesson.php";
switch ($_GET["action"])
{
    case "reg":
        $user = $_POST["user"];
        echo User::add($user);
        break;
    case "enter":
        $user = $_POST["user"];
        echo User::enter($user);
        break;
    case "my_cours":
        $userId = $_POST["user"];
        $user = new User($userId);

        $cours=[];
        foreach ($user->myCours as $id)
        {
            $cours[]= new Cours($id);
        }
        echo json_encode($cours);
        break;
    case "subscrib":
        $user_id = $_POST["user"];
        $cours = $_POST["cours"];

        $user=new User($user_id);

        echo $user->subscrib($cours);
        break;
    case "findSubscrib":
        $user_id = $_GET["user"];
        $user=new User($user_id);

        foreach ($user->subscribCours as $cours_id)
            $cours[]=new Cours($cours_id);

        echo json_encode($cours);
        break;
    case "add_lesson":
        $article_id= $_POST["article"];
        $user_id= $_POST["user"];
        $user=new User($user_id);
        $user->addLesson($article_id);
        $user->addRepeat($article_id);
        break;
    case "get_lesson_data":
        $article_id= $_POST["article"];
        $user_id= $_POST["user"];
        $lesson=new Lesson($user_id,$article_id);
        echo json_encode($lesson);
        break;
    case "get_repeat":
        $user_id=$_POST["user"];
        $user=new User($user_id);

        foreach ($user->lesson as $article_id)
            $lesson[]=new Lesson($user_id,$article_id);

        echo json_encode($lesson);

        break;


}