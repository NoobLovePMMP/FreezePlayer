<?php

namespace Noob\FreezePlayer\commands;

use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use Noob\FreezePlayer\FreezePlayer;
use pocketmine\Server;

class UnFreezeCommand extends Command implements PluginOwned
{
    private FreezePlayer $plugin;
    public string $prefix = "[Freeze] ";

    public function __construct(FreezePlayer $plugin)
    {
        $this->plugin = $plugin;
        parent::__construct("unfreeze", "unfreeze player", null, []);
        $this->setPermission("unfreeze.cmd");
    }

    public function execute(CommandSender $player, string $label, array $args)
    {
        if (!isset($args[0])) {
            $player->sendMessage($this->prefix . "/unfreeze <player's name>");
            return 0;
        }
        if(!$this->plugin->hasPlayer($args[0])){
            $player->sendMessage($this->prefix . "This player is not frozen");
            return 0;
        }
        $this->plugin->removePlayer($args[0]);
        $player->sendMessage($this->prefix . "You have unfrozen the player ". $args[0]);
    }

    public function getOwningPlugin(): FreezePlayer
    {
        return $this->plugin;
    }
}