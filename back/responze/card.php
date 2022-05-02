<?php

require_once "../object/card.php";
switch ($_GET["action"]) {
    case "add":

        $card = $_POST["card"];
        echo Card::add($card);
        break;

    case "find":

        $cards = $_POST["cards"];
        $cards_id = Card::find($cards);
        foreach ($cards_id as $card_id)
        {
            $card[]=new Card($card_id);
        }
        echo json_encode($card);
        break;


}