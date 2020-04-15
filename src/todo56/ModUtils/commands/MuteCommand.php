<?php
namespace todo56\ModUtils\commands;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;
use todo56\ModUtils\ModUtils;
use pocketmine\utils\TextFormat as C;
class MuteCommand extends Command
{
    protected $plugin;
    protected $description;
    protected $usageMessage;
    protected $config;

    public function __construct(ModUtils $plugin)
    {
        $this->plugin = $plugin;
        parent::__construct("mute");
        $this->description = "Mute command.";
        $this->usageMessage = "/mute [user]";
        $this->setPermission("modutils.command.mute");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(isset($args[0])){
            if($this->plugin->getServer()->getPlayer($args[0])){
                $pl = $this->plugin->getServer()->getPlayer($args[0])->getName();
                $this->plugin->mutes[] = $pl;
                $sender->sendMessage(C::GREEN . "$pl has been muted successfully.");
            } else {
                $sender->sendMessage(C::RED . "Mention a valid player.");
            }
        } else {

        }
    }
}