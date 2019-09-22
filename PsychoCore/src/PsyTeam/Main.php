<?php

namespace PsyTeam;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use PsyTeam\Form\game\JoinForm;
use PsyTeam\Form\ModalForm;
use PsyTeam\Form\CustomForm;
use PsyTeam\Form\SimpleForm;

class Main extends PluginBase implements Listener {


    public function onEnable(){

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



    }

    public function onPC(PlayerCreationEvent $event){
        $event->setPlayerClass(PsyPlayer::class);
    }

    public function onJoin(PlayerJoinEvent $event) {
        $event->getPlayer()->sendForm(new JoinForm());
        $event->getPlayer()->addTitle(TextFormat::YELLOW . "Welcome to PF!" , TextFormat::GREEN . "This is Beta!");
    }

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
    public function createModalForm(?callable $function = null) : ModalForm
    {
        return new ModalForm($function);
    }


}
