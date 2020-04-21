<?php
namespace todo56\ModUtils\commands;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;
use todo56\ModUtils\ModUtils;
use pocketmine\utils\TextFormat as C;
use pocketmine\entity\Skin;
use todo56\ModUtils\utils\SkinManager;
class RemoveskinCommand extends Command
{
    protected $plugin;
    protected $description;
    protected $usageMessage;
    protected $config;

    public function __construct(ModUtils $plugin)
    {
        $this->plugin = $plugin;
        parent::__construct("removeskin");
        $this->description = "Removeskin command.";
        $this->usageMessage = "/removeskin [user]";
        $this->setPermission("modutils.command.rs");
        $this->setAliases(["rs"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(isset($args[0])){
            if($this->plugin->getServer()->getPlayer($args[0])){
                $player = $this->plugin->getServer()->getPlayer($args[0]);
                $skins = new SkinManager($this->plugin);
                $skins->setSteveSkin($player);
                $reason = "";
                if(isset($args[1])){
                    array_shift($args);
                   $reason = join(" ",$args);
                }
                if($reason !== ""){
                    $player->sendMessage(C::RED . "Your skin has been removed by " . $sender->getName() ." for: $reason");
                } else {
                    $player->sendMessage(C::RED . "Your skin has been removed by " . $sender->getName() . ".");
                }
            } else {
                $sender->sendMessage(C::RED . "Mention a valid player.");
            }
        } else {

        }
    }
}