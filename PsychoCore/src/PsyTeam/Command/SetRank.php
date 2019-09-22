<?php

namespace PsyTeam\Command;

use pocketmine\command\PluginCommand;
use PsyTeam\Main;
use pocketmine\command\CommandSender;
use PsyTeam\PsyPlayer as Player;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;

class SetRank extends PluginCommand{

    public function __construct(string $name, Main $owner){
        parent::__construct($name, $owner);

        $this->setDescription("Admins: Set someone's rank");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){

        if($sender instanceof Player){
            if($sender->getRank() != "owner" || $sender->getRank() != "admin"){
                $sender->sendMessage(TextFormat::RED . "For server owners only.");
                return true;
            }

            if(count($args) !== 2){
                $sender->sendMessage(TextFormat::RED . "Use like this: /setrank (player) (rank)");
                return true;
            }

            $ranks = new Config($this->getPlugin()->getDataFolder() . "Ranks.yml", Config::YAML);
            $ranks->set(strtolower($args[0]), strtolower($args[1]));
            $sender->sendMessage(TextFormat::YELLOW . "[!]" . TextFormat::GREEN . "Added rank successfully.");

            if($p = $this->getPlugin()->getServer()->getPlayer($args[0])){
                $p->sendMessage(TextFormat::YELLOW . "[!]" . TextFormat::LIGHT_PURPLE . "Your rank is now " . TextFormat::AQUA . strtolower($args[1]));
            }
            return true;
        }else{
            if(count($args) !== 2){
                $sender->sendMessage(TextFormat::RED . "Use like this: /setrank (player) (rank)");
                return true;
            }

            $ranks = new Config($this->getPlugin()->getDataFolder() . "Ranks.yml", Config::YAML);
            $ranks->set(strtolower($args[0]), strtolower($args[1]));
            $sender->sendMessage(TextFormat::YELLOW . "[!]" . TextFormat::GREEN . "Added rank successfully.");
            return true;
        }
    }
}