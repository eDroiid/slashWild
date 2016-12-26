<?php

namespace LEET;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\level\{Level,Position,ChunkManager};
use pocketmine\math\Vector3;

class Wild extends PluginBase implements Listener {
	
	public function onEnable() {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->info("slashWild is enabled!");
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, $label, array $param ) {
		switch(strtolower($cmd->getName())) {
		
			case "wild":
				if($sender->hasPermission("slashWild.command.wild")) {
					if($sender instanceof Player) {
						
						$x = rand(1,350000);
						$z = rand(1,350000);
						for($i = 0; $i < 128; $i++){
							if(ChunkManager->getBlockIdAt($x, $i, $z) === 0){
								if(ChunkManager->getBlockIdAt($x, $i+1, $z) === 0){
									$y = $i;
								}
							}
						}
						if(!isset($y)){
							$y = 128;	
						}
						$sender->teleport(new Position($x,$y,$z));
						$sender->sendTip("WILD");
						$sender->sendMessage("[slashWild] teleported to: X-".$x." Y-".$y." Z-".$z);
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
