<?php
require_once "../object/chapter.php";
switch ($_GET["action"])
{
    case "add":

        $chapter = $_POST["chapter"];

        echo Chapter::add($chapter);
        break;



}