<?php

namespace Noob\FreezePlayer\event;

use Noob\FreezePlayer\FreezePlayer;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\player\Player;

class EventListener implements Listener {

    public function onMove(PlayerMoveEvent $ev){
        $player = $ev->getPlayer();
        if(FreezePlayer::getFreeze()->hasPlayer($player->getName())){
            $ev->cancel();
            $player->sendPopup("You are frozen");
        }
    }
}