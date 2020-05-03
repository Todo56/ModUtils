<?php
namespace todo56\ModUtils;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use todo56\ModUtils\commands\MuteCommand;
use todo56\ModUtils\commands\RemoveskinCommand;
use todo56\ModUtils\utils\PunishmentsManager;
class ModUtils extends PluginBase{
    public $mutes;
    public $bans;
    public $purechat = null;
    public $config;
    public function onEnable()
    {
        @mkdir($this->getDataFolder());
        $this->saveResource("config.yml");
        $this->saveResource("/db/mutes.yml");
        $this->saveResource("skin.png");
        $this->saveResource("/db/bans.yml");
        $this->saveResource("/db/skins.yml");
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->mutes = new Config($this->getDataFolder() . "/db/mutes.yml", Config::YAML);
        $this->bans = new Config($this->getDataFolder() . "/db/bans.yml", Config::YAML);
        $this->getLogger()->info("Mod Utils is loading.");
        $this->getServer()->getPluginManager()->registerEvents(new ModListener($this), $this);
        $commandMap = $this->getServer()->getCommandMap();
        $commandMap->register("ModUtils", new MuteCommand($this));
        $commandMap->register("ModUtils", new RemoveskinCommand($this));
        if($this->config->get("purechat-support") === true){
            if($this->getServer()->getPluginManager()->getPlugin("PureChat")){
                $this->purechat = $this->getServer()->getPluginManager()->getPlugin("PureChat");
                $this->getLogger()->info("PureChat support enabled!");
            } else {
                $this->getLogger()->warning("PureChat not found.");
            }
        }
    }
}