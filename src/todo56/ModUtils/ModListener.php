<?php
namespace todo56\ModUtils;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\Item;
use pocketmine\event\player\PlayerInteractEvent;
use jojoe77777\FormAPI;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\utils\TextFormat as C;

class ModListener implements Listener {
    protected $plugin;
    public function __construct(ModUtils $plugin)
    {
        $this->plugin = $plugin;
    }
    public function onJoin(PlayerJoinEvent $ev){
        $player = $ev->getPlayer();

    }
    public function onChat(PlayerChatEvent $ev){
        $player = $ev->getPlayer();
        if(isset($this->plugin->mutes[$player->getName()])){
            $player->sendMessage(C::RED . "You are muted.");
            $ev->setCancelled(true);
        }
    }
}


