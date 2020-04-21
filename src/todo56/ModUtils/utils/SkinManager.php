<?
namespace todo56\ModUtils\utils;
use pocketmine\entity\Skin;
use todo56\ModUtils\ModUtils;
use pocketmine\Player;
class SkinManager {
    public $plugin;
    public function __construct(ModUtils $plugin)
    {
        $this->plugin = $plugin;
    }
    public function setSteveSkin(Player $player){
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
        $skin = new Skin("Standard_Custom", $data);
        $player->setSkin($skin);
        $player->sendSkin($this->plugin->getServer()->getOnlinePlayers());
    }
}