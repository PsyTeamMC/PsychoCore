<?php

namespace PsyTeam;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use PsyTeam\Form\game\JoinForm;
use PsyTeam\Form\ModalForm;
use PsyTeam\Form\CustomForm;
use PsyTeam\Form\SimpleForm;
use PsyTeam\Command\SetRank;
use PsyTeam\Command\AddMoney;

class Main extends PluginBase implements Listener {


    public function onEnable(){

        $this->saveResource($this->getDataFolder() . "Ranks.yml");
        $this->saveResource($this->getDataFolder() . "Coins.yml");

        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);


        $lna = scandir($this->getServer()->getDataPath() . "worlds/");

        foreach($lna as $ln) {
            if($ln === "." || $ln === "..") {
                continue;
            }
            $this->getServer()->loadLevel($ln);
        }
        $l = $this->getServer()->getLevels();

        $this->getServer()->getCommandMap()->register("PC", new SetRank("rank", $this));
        $this->getServer()->getCommandMap()->register("PC", new AddMoney("addmoney", $this));



    }

    public function onDisable(){
        $this->saveResource($this->getDataFolder() . "Ranks.yml");
        $this->saveResource($this->getDataFolder() . "Coins.yml");
    }

    public function onPC(PlayerCreationEvent $event){
        $event->setPlayerClass(PsyPlayer::class);
    }

    public function onJoin(PlayerJoinEvent $event) {
        if($event->getPlayer() instanceof PsyPlayer){
        $event->getPlayer()->sendForm(new JoinForm());
        $event->getPlayer()->addTitle(TextFormat::YELLOW . "Welcome to PF!" , TextFormat::GREEN . "This is Beta!");

        if(!$event->getPlayer()->hasPlayedBefore()) {

            $ranks = new Config($this->getPlugin()->getDataFolder() . "Ranks.yml", Config::YAML);
            $ranks->set(strtolower($event->getPlayer()->getName()), "default");

            $money = new Config($this->getPlugin()->getDataFolder() . "Money.yml", Config::YAML);
            $money->set(strtolower($event->getPlayer()->getName()), 0);

            $this->getServer()->broadcastMessage(TextFormat::YELLOW . "[!] " . TextFormat::AQUA . "Please welcome " . $event->getPlayer()->getName() . "to the server!");
        }
        }
    }

    public function onChat(PlayerChatEvent $event){
        $msg = $event->getMessage();
        $p = $event->getPlayer();

        if($p instanceof PsyPlayer) {

            if ($p->getRank() == "owner") {
                $event->setFormat(TextFormat::BLUE . TextFormat::BOLD . "OWNER " . TextFormat::RESET . TextFormat::YELLOW . $p->getName() . " " . TextFormat::GRAY . $msg);
            } elseif ($p->getRank() == "admin") {
                $event->setFormat(TextFormat::GREEN . TextFormat::BOLD . "ADMIN " . TextFormat::RESET . TextFormat::YELLOW . $p->getName() . " " . TextFormat::GRAY . $msg);
            } else {
                $event->setFormat(TextFormat::YELLOW . $p->getName() . TextFormat::GRAY . " " . $msg);
            }
        }
    }

    /*

     public function onBlockBreak(BlockBreakEvent $event){
        if($event->getBlock()->getLevel()->getName() == "world"){
            $event->setCancelled();
        }
    }

    public function onBlockPlace(BlockPlaceEvent $event){
        if($event->getBlock()->getLevel()->getName() == "world"){
            $event->setCancelled();
        }
    }
    */

    /**
     *
     * @param callable|null $function
     * @return CustomForm
     */
    public function createCustomForm(?callable $function = null) : CustomForm {
        return new CustomForm($function);
    }

    /**
     *
     * @param callable|null $function
     * @return SimpleForm
     */
    public function createSimpleForm(?callable $function = null) : SimpleForm {
        return new SimpleForm($function);
    }

    /**
     *
     * @param callable|null $function
     * @return ModalForm
     */
    public function createModalForm(?callable $function = null) : ModalForm{
        return new ModalForm($function);
    }


}

