<?php
declare(strict_types=1);

namespace wildan\nospace;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class NoSpace extends PluginBase implements Listener{
    protected function onEnable() : void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
    }

    public function onPlayerLogin(PlayerLoginEvent $event) : void{
        $player = $event->getPlayer();
        $playerName = $player->getName();

		if(str_contains($playerName, " ")) {
			if($this->getConfig()->get("ban-mode", false) == true) {
				$this->getServer()->getNameBans()->addBan($playerName, $this->getConfig()->get("ban-message", "Your name is contain space, you can't play on this server!"), null, $this->getName());
				$player->kick("You are banned from this server. Reason: " . $this->getConfig()->get("ban-message", "Your name is contain space, you can't play on this server!"));
			} else {
            	$player->kick(TextFormat::colorize($this->getConfig()->get("kick-message", "&cYour name is contain space, please change it before login again!")));
        	}
        }
    }
}
