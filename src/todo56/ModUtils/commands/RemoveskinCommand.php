<?php
namespace todo56\ModUtils\commands;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;
use todo56\ModUtils\ModUtils;
use pocketmine\utils\TextFormat as C;
use pocketmine\entity\Skin;
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
        $image = imagecreatefrompng($this->plugin->getDataFolder() . "skin.png");
        $data = '';
        for ($y = 0, $height = imagesy($image); $y < $height; $y++) {
            for ($x = 0, $width = imagesx($image); $x < $width; $x++) {
                $color = imagecolorat($image, $x, $y);
                $data .= pack("c", ($color >> 16) & 0xFF) //red
                    . pack("c", ($color >> 8) & 0xFF) //green
                    . pack("c", $color & 0xFF) //blue
                    . pack("c", 0xFF); //alpha
            }
        }
        if(isset($args[0])){
            if($this->plugin->getServer()->getPlayer($args[0])){
                $pl = $this->plugin->getServer()->getPlayer($args[0]);
                $skin = new Skin("Standard_Custom", $data);
                $pl->setSkin($skin);
                $pl->sendSkin($this->plugin->getServer()->getOnlinePlayers());

            } else {
                $sender->sendMessage(C::RED . "Mention a valid player.");
            }
        } else {

        }
    }
}