<?php

namespace PsyTeam;

use pocketmine\Player;
use pocketmine\utils\Config;
use Exception;

class PsyPlayer extends Player{

    public function getRank(){
        $file = new Config("plugin_data/PsyCore/Ranks.yml", Config::YAML);
        if($file->exists(strtolower($this->getName()))){
            return $file->get(strtolower($this->getName()));
        }else{
            return null;
        }
    }

    public function getMoney(){
        $file = new Config("plugin_data/PsyCore/Money.yml", Config::YAML);
        if($file->exists(strtolower($this->getName()))){
            return $file->get(strtolower($this->getName()));
        }else{
            return null;
        }
    }

    public function addMoney(int $amount){
        $file = new Config("plugin_data/PsyCore/Money.yml", Config::YAML);
        if($file->exists(strtolower($this->getName()))){
            $file->set(strtolower($this->getName()), $this->getMoney() + $amount);
            $file->save();
        }else{
            throw new Exception("Player has not joined!");
        }
    }

    public function takeMoney(int $amount){
        $file = new Config("plugin_data/PsyCore/Money.yml", Config::YAML);
        if($file->exists(strtolower($this->getName()))){
            $file->set(strtolower($this->getName()), $this->getMoney() - $amount);
            $file->save();
        }else{
            throw new Exception("Player has not joined!");
        }
    }

    public function setMoney(int $amount){
        $file = new Config("plugin_data/PsyCore/Money.yml", Config::YAML);
        if($file->exists(strtolower($this->getName()))){
            $file->set(strtolower($this->getName()), $amount);
            $file->save();
        }else{
            throw new Exception("Player has not joined!");
        }
    }

    public function setRank($rank){
        $file = new Config("plugin_data/PsyCore/Ranks.yml", Config::YAML);
        if($file->exists(strtolower($this->getName()))){
            $file->set(strtolower($this->getName()), $rank);
            $file->save();
        }else{
            throw new Exception("Player has not joined!");
        }
    }

}
