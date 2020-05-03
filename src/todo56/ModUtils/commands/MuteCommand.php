<?php
namespace todo56\ModUtils\commands;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;
use todo56\ModUtils\ModUtils;
use pocketmine\utils\TextFormat as C;
use todo56\ModUtils\utils\Other;
use todo56\ModUtils\utils\StaffChat;

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
        $all = $this->plugin->config->getAll();
        if(isset($args[0])){
            if($this->plugin->getServer()->getPlayer($args[0])){
                $pl = $this->plugin->getServer()->getPlayer($args[0])->getName();
                $array = [];
                if($this->plugin->mutes->get($pl)){
                    $sender->sendMessage(C::RED . "This user is already muted!");
                    return true;
                }
                $array["mod"] = $sender->getName();
                $array["date"] = date("d/m/Y G:i:s");
                if(isset($args[1])){
                    array_shift($args);
                    var_dump($args);
                    $array["reason"] = implode(" ", $args);
                } else {
                    $array["reason"] = "";
                }
                $this->plugin->mutes->set($pl, $array);
                $this->plugin->mutes->save();
                $mute_command = $all["commands"]["mute"];
                $staffchat  = new StaffChat($this->plugin);
                $sender->sendMessage(Other::replaceVars($mute_command["mute-success"], ["{player}" =>$pl]));
                if($mute_command["broadcast"]){
                    if($array["reason"] !== ""){
                        $this->plugin->getServer()->broadcastMessage(Other::replaceVars($mute_command["broadcast-message"], ["{mod}" => $sender->getName(), "{player}" => $pl, "{reason}" => $array["reason"]]));
                        if($mute_command["staff-chat"]){
                            $staffchat->sendMessage(Other::replaceVars($mute_command["staff-chat-message"], ["{mod}" => $sender->getName(), "{player}" => $pl, "{reason}" => $array["reason"]]));
                        }
                    } else {
                        $this->plugin->getServer()->broadcastMessage(Other::replaceVars($mute_command["broadcast-message-nr"], ["{mod}" => $sender->getName(), "{player}" => $pl]));
                        if($mute_command["staff-chat"]){
                            $staffchat->sendMessage(Other::replaceVars($mute_command["staff-chat-message-nr"], ["{mod}" => $sender->getName(), "{player}" => $pl]));
                        }
                    }
                }
            } else {
                $sender->sendMessage(C::RED . "Mention a valid player.");
            }
        } else {

        }
    }
}