<?php

namespace slashWild;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\level\{Level,Position,ChunkManager};
use pocketmine\math\Vector3;

class Wild extends PluginBase {

	public function onEnable() {
		$this->getLogger()->info("slashWild is enabled!");
	}

	public function onCommand(CommandSender $sender, Command $cmd, $label, array $param ) {
		switch(strtolower($cmd->getName())){
			case "wild":
				if($sender->hasPermission("slashWild.command.wild")) {
					if($sender instanceof Player) {
						$x = rand(1,350000);
            					$y = rand(1,256);
						$z = rand(1,350000);
						$sender->teleport($sender->getLevel()->getSafeSpawn(new Vector3($x, $y, $z)));
						$sender->sendTip("[slashWild] You've been teleported somewhere wild!");
						$sender->sendMessage("[slashWild] teleporting to: X-$x Z-$z");
					}
					else {
						$sender->sendMessage("[slashWild] Only in-game!");
					}
				}
				else {
					$sender->sendMessage("[slashWild] You have no permission to use this command!");
				}
				return true;
			break;

		}
	}
	public function onDisable() {
		$this->getLogger()->info("slashWild has been disabled!");
	}

}
