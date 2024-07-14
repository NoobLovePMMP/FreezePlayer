<?php

namespace Noob\FreezePlayer\commands;

use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use Noob\FreezePlayer\FreezePlayer;
use pocketmine\Server;

class FreezeCommand extends Command implements PluginOwned
{
    private FreezePlayer $plugin;
    public string $prefix = "[Freeze] ";

    public function __construct(FreezePlayer $plugin)
    {
        $this->plugin = $plugin;
        parent::__construct("freeze", "freeze player", null, []);
        $this->setPermission("freeze.cmd");
    }

    public function execute(CommandSender $player, string $label, array $args)
    {
        if (!isset($args[0])) {
            $player->sendMessage($this->prefix . "/freeze <player's name>");
            return 0;
        }
        if($this->plugin->hasPlayer($args[0])){
            $player->sendMessage($this->prefix . "Player was frozen before");
            return 0;
        }
        $this->plugin->addPlayer($args[0]);
        $player->sendMessage($this->prefix . "You have frozen the player ". $args[0]);
    }

    public function getOwningPlugin(): FreezePlayer
    {
        return $this->plugin;
    }
}