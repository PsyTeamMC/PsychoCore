<?php

namespace PsyTeam\Form\game;

use pocketmine\Player;
use pocketmine\utils\TextFormat;
use PsyTeam\Form\SimpleForm;

class JoinForm extends SimpleForm{

    public function __construct(){

        parent::__construct(function(Player $player, ?int $data){

        });

        $this->setTitle(TextFormat::BLUE . TextFormat::BOLD . "SERVER NEWS");
        $this->setContent(TextFormat::YELLOW . "Welcome to the PsychoFactions beta!");
        $this->addButton("OK");
    }

    public function handleResponse(Player $player, $response): void{

        if($response === null) return;

        if($response) return;
    }
}