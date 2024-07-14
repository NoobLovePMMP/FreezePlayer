<?php

namespace Noob\FreezePlayer;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;
use pocketmine\player\Player;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\Server;
use Noob\FreezePlayer\commands\FreezeCommand;
use Noob\FreezePlayer\commands\UnFreezeCommand;
use Noob\FreezePlayer\event\EventListener;


class FreezePlayer extends PluginBase {

    public $freeze;
	public static $instance;

	public static function getFreeze() : self {
		return self::$instance;
	}

	public function onEnable(): void{
        self::$instance = $this;
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
        $this->getServer()->getCommandMap()->register("/freeze", new FreezeCommand($this));
        $this->getServer()->getCommandMap()->register("/unfreeze", new UnFreezeCommand($this));
        $this->freeze = new Config($this->getDataFolder() . "freeze.yml", Config::YAML, ["player-freeze" => []]);
	}

    public function getPlayer(){
        return $this->freeze;
    }

    public function hasPlayer(string $playerName): bool{
        foreach($this->getPlayer()->get("player-freeze") as $data => $value){
            if($value == $playerName) return true;
        }
        return false;
    }

    public function addPlayer(string $playerName): void{
        $insert = [$playerName];
        if($this->getPlayer()->get("player-freeze") === []){
            $this->getPlayer()->set("player-freeze", array_merge($this->getPlayer()->get("player-freeze"), $insert));
            $this->getPlayer()->save();
        }
        else{
            $this->getPlayer()->set("player-freeze", array_merge($this->getPlayer()->get("player-freeze"), $insert));
            $this->getPlayer()->save();
        }
    }

    public function removePlayer(string $playerName): void{
        $this->getPlayer()->set("player-freeze", []);
        $this->getPlayer()->save();
        foreach($this->getPlayer()->get("player-freeze") as $data => $value){
            if($value != $playerName) $this->addPlayer($playerName);
        }
    }
}