<?php

namespace slashWild;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\math\Vector3;

class Wild extends PluginBase {

	public function onEnable() {
		$this->getLogger()->info("slashWild is enabled!");
	}
	
	public function onDisable() {
		$this->getLogger()->info("slashWild has been disabled!");
	}

	public function onCommand(CommandSender $sender, Command $cmd, $label, array $param ) {
		if(strtolower($cmd->getName()) === 'wild') {
			if($sender instanceof Player) {
				if(!$sender->hasPermission("slashWild.command.wild")) {
					$sender->sendMessage("[slashWild] You have no permission to use this command!");
					return true;
				} else {
					$rp = $this->getRandomPosition($sender->getLevel(), [1, 350000], [5, 256], [1, 350000], true, 2);
					if($rp) {
						$sender->teleport($rp->getLevel()->getSafeSpawn());
						$sender->teleport($rp);
						$sender->sendTip("[slashWild] You've been teleported somewhere wild!");
						$sender->sendMessage("[slashWild] teleporting to: X-{$rp->x} Y-{$rp->y} Z-{$rp->z}");	
					} else {
						$sender->sendMessage("[slashWild] Sorry, but I failed to find safe place for you to teleport, try again later.");
					}
				}
			} else {
				$sender->sendMessage("[slashWild] Use this command only in-game!");
			}
		}
		return true;
	}
	
	public function getRandomPosition(Level $level, $xRange, $yRange, $zRange, bool $safe = true, int $tries = 1) {
		$try = 0;
		$pos = null;
		do {
			foreach(['x', 'y', 'z'] as $c) {
				${$c."Min"} = is_array(${$c."Range"}) ? min(${$c."Range"}) : 0;
				${$c."Max"} = is_array(${$c."Range"}) ? max(${$c."Range"}) : 0xFF;
			}
			if($safe) {
				for($y = $yMin; $y <= $yMax; $y++) {
					$pos = new Position(mt_rand($xMin, $xMax), $y, mt_rand($zMin, $zMax), $level);
					if($this->isSafe($pos)) break 2;
				}
			} else {
				$pos = new Position(mt_rand($xMin, $xMax), mt_rand($yMin, $yMax), mt_rand($zMin, $zMax), $level);	
			}
			$try++;
		} while($try < $tries || $safe && !$this->isSafe($pos));
		return if($this->isSafe($pos)) ? $pos : null;
	}
	
	public function isSafe(Position $position) : bool {
		return true;
	}

}
