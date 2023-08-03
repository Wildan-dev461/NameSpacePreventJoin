<?php

declare(strict_types=1);

namespace Wildan/NoSpace;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener {

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onPlayerJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $playerName = $player->getName();

        if (strpos($playerName, " ") !== false) {
            $player->kick(TextFormat::RED . "Your name is contain space, please change it before login again!");
        }
    }
}
