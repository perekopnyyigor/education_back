<?php
require_once "../object/article.php";
switch ($_GET["action"])
{
    case "add":
        $article = $_POST["article"];
        echo Article::add($article);
        break;
    case "save":
        $article = $_POST["article"];
        echo Article::save($article);
        break;
    case "article":
        $id= $_GET["id"];
        $article = new Article($id,true);
        echo json_encode($article);

        break;
    case "add_img":
        $id= $_POST["article"];
        $article = new Article($id,true);
        $article->uploadImg();
        break;
    case "save_option":
        $option=$_POST["option"];
        echo Article::saveOptions($option);
        break;
    case "all_article":
        $article_id=Article::findArticle();
        foreach($article_id as $id)
        {
            $articles[]=new Article($id,false);
        }
        echo json_encode($articles);
        break;


}
