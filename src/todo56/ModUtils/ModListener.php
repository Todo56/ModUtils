<?php
namespace todo56\ModUtils;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\Item;
use pocketmine\event\player\PlayerInteractEvent;
use jojoe77777\FormAPI;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\utils\TextFormat as C;
use todo56\ModUtils\utils\StaffChat;
use todo56\ModUtils\utils\Other;
class ModListener implements Listener
{
    protected $plugin;
    public $staffchat;

    public function __construct(ModUtils $plugin)
    {
        $this->plugin = $plugin;
        $this->staffchat = new StaffChat($this->plugin);
    }

    public function onJoin(PlayerJoinEvent $ev)
    {
        $player = $ev->getPlayer();
        if ($player->hasPermission("modutils.staffchat")) {
            $all = $this->plugin->config->getAll();

            $this->staffchat->sendMessage(Other::replaceVars($all["staffchat"]["join-message"], ["{player}" => $player->getName()]));
        }
    }

    public function onChat(PlayerChatEvent $ev)
    {
        $player = $ev->getPlayer();
        if ($this->plugin->mutes->get($player->getName())) {
            $player->sendMessage(C::RED . "You are muted.");
            $ev->setCancelled(true);
        }
        if ($player->hasPermission("modutils.staffchat.chat")) {
            $message = $ev->getMessage();
            $all = $this->plugin->config->getAll();
            if ($this->startsWith($message, $all["staffchat"]["prefix"])) {
                $msg = substr($message, strlen($all["staffchat"]["prefix"]));
                $this->staffchat->sendMessage(Other::replaceVars($all["staffchat"]["message-format"], ["{msg}"=>$msg, "{player}" => $ev->getPlayer()->getName()]));
                $ev->setCancelled();
            }
        }
    }

    public function onLeave(PlayerQuitEvent $ev)
    {
        $player = $ev->getPlayer();
        if ($player->hasPermission("modutils.staffchat")) {
            $all = $this->plugin->config->getAll();
            $this->staffchat->sendMessage(Other::replaceVars($all["staffchat"]["leave-message"], ["{player}" => $player->getName()]));
        }
    }

    public function startsWith($string, $startString)
    {
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    }
}


