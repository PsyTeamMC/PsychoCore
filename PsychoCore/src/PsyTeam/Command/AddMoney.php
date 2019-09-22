<?php

namespace PsyTeam\Command;

use pocketmine\command\PluginCommand;
use PsyTeam\Main;
use pocketmine\command\CommandSender;
use PsyTeam\PsyPlayer as Player;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;

class AddMoney extends PluginCommand{

    public function __construct(string $name, Main $owner){
        parent::__construct($name, $owner);

        $this->setDescription("Admins: Give extra money to a player");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){

        if($sender instanceof Player){
            if($sender->getRank() != "owner" && $sender->getRank() != "admin"){
                $sender->sendMessage(TextFormat::RED . "For server owners only.");
                return true;
            }

            if(count($args) !== 2){
                $sender->sendMessage(TextFormat::RED . "Use like this: /addmoney (player) (amount)");
                return true;
            }

            if(!is_numeric($args[1])){
                $sender->sendMessage(TextFormat::RED . "Use like this: /addmoney (player) (amount)");
                return true;
            }

            $player = $this->getPlugin()->getServer()->getPlayer($args[0]);

            if($player instanceof Player){
                try{
                    $player->addMoney((int) $args[1]);
                    $sender->sendMessage(TextFormat::YELLOW . "[!] " . TextFormat::GREEN . "Added money successfully.");
                    $player->sendMessage(TextFormat::YELLOW . "[!] " . TextFormat::LIGHT_PURPLE . "Your money is now " . TextFormat::AQUA . $args[1] + $player->getMoney());
                    return true;
                }catch(\Exception $e){
                    $money = new Config($this->getPlugin()->getDataFolder() . "Money.yml", Config::YAML);
                    $money->set(strtolower($args[0]), $args[1]);
                    $sender->sendMessage(TextFormat::YELLOW . "[!] " . TextFormat::GREEN . "Player had no data set up, added money successfully via Money file.");
                    return true;
                }
            }else{
                $money = new Config($this->getPlugin()->getDataFolder() . "Money.yml", Config::YAML);
                $money->set(strtolower($args[0]), $args[1]);
                $sender->sendMessage(TextFormat::YELLOW . "[!] " . TextFormat::GREEN . "Player was not online, added money successfully via Money file.");
                return true;
            }
        }else{
            if(count($args) !== 2){
                $sender->sendMessage(TextFormat::RED . "Use like this: /addmoney (player) (amount)");
                return true;
            }

            if(!is_numeric($args[1])){
                $sender->sendMessage(TextFormat::RED . "Use like this: /addmoney (player) (amount)");
                return true;
            }

            $player = $this->getPlugin()->getServer()->getPlayer($args[0]);

            if($player instanceof Player){
                try{
                    $player->addMoney((int) $args[1]);
                    $sender->sendMessage(TextFormat::YELLOW . "[!] " . TextFormat::GREEN . "Added money successfully.");
                    $player->sendMessage(TextFormat::YELLOW . "[!] " . TextFormat::LIGHT_PURPLE . "Your money is now " . TextFormat::AQUA . $args[1]);
                    return true;
                }catch(\Exception $e){
                    $money = new Config($this->getPlugin()->getDataFolder() . "Money.yml", Config::YAML);
                    $money->set(strtolower($args[0]), $args[1]);
                    $sender->sendMessage(TextFormat::YELLOW . "[!] " . TextFormat::GREEN . "Player had no data set up, added money successfully via Money file.");
                    return true;
                }
            }else{
                $money = new Config($this->getPlugin()->getDataFolder() . "Money.yml", Config::YAML);
                $money->set(strtolower($args[0]), $args[1]);
                $sender->sendMessage(TextFormat::YELLOW . "[!] " . TextFormat::GREEN . "Player was not online, added money successfully via Money file.");
                return true;
            }

        }
    }
}
