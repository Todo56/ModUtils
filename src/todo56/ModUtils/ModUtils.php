<?php
namespace todo56\ModUtils;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use todo56\ModUtils\commands\MuteCommand;
use todo56\ModUtils\commands\RemoveskinCommand;

class ModUtils extends PluginBase{
    public $mods = [];
    public $mutes;
    public $bans;
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
        var_dump($this->mutes);
        $this->getLogger()->info("Mod Utils is loading.");
        $this->getServer()->getPluginManager()->registerEvents(new ModListener($this), $this);
        foreach($this->getServer()->getOnlinePlayers() as $player){
            if($player->hasPermission("mod")){
                $this->mods[] = $player->getName();
            }
        }
        $commandMap = $this->getServer()->getCommandMap();
        $commandMap->register("ModUtils", new MuteCommand($this));
        $commandMap->register("ModUtils", new RemoveskinCommand($this));

    }
}