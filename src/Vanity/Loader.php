<?php declare(strict_types=1);

namespace Vanity;

use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use Vanity\commands\ParticleCommand;
use pocketmine\utils\TextFormat as C;
use Vanity\commands\TagCommand;

class Loader extends PluginBase {
    public static array $TASKS = [];

    public function onEnable(): void {
        $this->getLogger()->info(C::GREEN . "Vanity Core has been enabled");
        $this->getServer()->getCommandMap()->registerAll($this->getFullName(), [new ParticleCommand($this), new TagCommand($this)]);
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        Vanity::new($this);
    }
}