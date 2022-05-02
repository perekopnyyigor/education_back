<?php
require_once "../object/cours.php";
require_once "../object/chapter.php";
require_once "../object/article.php";
switch ($_GET["action"])
{
    case "add":
        $cours = $_POST["cours"];
        echo Cours::add($cours);
        break;

    case "chapters":

        $cours_id = $_POST["cours_id"];
        $cours = new Cours($cours_id);
        $chaptersId=$cours->findChapters();
        //$chapters=[];


        for($i=0;$i<count($chaptersId);$i++)
        {
            $chapters[$i]= new Chapter($chaptersId[$i]);


            $articlesId=$chapters[$i]->articlesId;
            if($articlesId!="" && $articlesId!=null)
            {
                for($j=0;$j<count($articlesId);$j++)
                {
                    $chapters[$i]->articles[$j]=new Article($articlesId[$j],false);
                }
            }

        }

        echo json_encode($chapters);
        break;

    case "delete":
        $id = $_GET["id"];
        $cours=new Cours($id);
        echo $cours->delete();
        break;

    case "find_cours":
        $coursId = Cours::findCours();
        $cours=[];
        foreach ($coursId as $id)
        {
            $cours[]=new Cours($id);
        }
        echo json_encode($cours);
        break;
    case "find_one_cours":
            $cours=new Cours($_GET["id"]);
        echo json_encode($cours);
        break;
    case "save_option":
        $option=$_POST["option"];

        Cours::saveOptions($option);
        break;



}
