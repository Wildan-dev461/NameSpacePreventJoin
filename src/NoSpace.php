<?php

declare(strict_types=1);

namespace wildan\nospace;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class NoSpace extends PluginBase implements Listener {
    protected function onEnable() : void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
    }

    public function onPlayerLogin(PlayerLoginEvent $event) : void {
        $player = $event->getPlayer();
        $playerName = $player->getDisplayName();

        if (str_contains($playerName, " ")) {
            $kickEnabled = $this->getConfig()->get("kick-on-space", true);

            if (!$kickEnabled) {
                $message = $this->getConfig()->get("no-kick-message", "&eYour name contains spaces. Please consider changing it.");
                $player->sendMessage(TextFormat::colorize($message));
                return;
            }

            if ($this->getConfig()->get("ban-mode", false) == true) {
                $this->getServer()->getNameBans()->addBan($playerName, $this->getConfig()->get("ban-message", "Your name contains spaces, you can't play on this server!"), null, $this->getName());
                $player->kick("You are banned from this server. Reason: " . $this->getConfig()->get("ban-message", "Your name contains spaces, you can't play on this server!"));
            } else {
                $player->kick(TextFormat::colorize($this->getConfig()->get("kick-message", "&cYour name contains spaces, please change it before logging in again!")));
            }
        }
    }
}
