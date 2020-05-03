<?php

namespace todo56\ModUtils\utils;

use pocketmine\Player;
use todo56\ModUtils\ModUtils;

class StaffChat
{
    public $plugin;

    public function __construct(ModUtils $plugin)
    {
        $this->plugin = $plugin;
    }
    public function sendMessage(string $message){
        foreach($this->plugin->getServer()->getOnlinePlayers() as $pl) {
            if($pl->hasPermission("modutils.staffchat")){
                $pl->sendMessage($message);
            }
        }
    }
}