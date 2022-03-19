<?php declare(strict_types=1);

namespace Vanity;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\scheduler\Task;
use pocketmine\event\player\PlayerMoveEvent;
use Vanity\tasks\DisplayPlayerParticleTask;
use CortexPE\HRKChat\event\PlaceholderResolveEvent;

class EventListener implements Listener {
    private Loader $plugin;

    public function __construct(Loader $plugin) {
        $this->plugin = $plugin;
    }

    public function onJoin(PlayerJoinEvent $e): void {
        $p = $e->getPlayer();
        [$_, $particle] = Vanity::getVanity($p);
        if($particle) {
            $this->plugin::$TASKS[strtolower($p->getName())] = new DisplayPlayerParticleTask($p, $particle);
            /** @var Task */
            $task = $this->plugin::$TASKS[strtolower($p->getName())];
            $this->plugin->getScheduler()->scheduleTask($task);
        }
    }

    public function onPlaceholderResolve(PlaceholderResolveEvent $e): void {
        if($e->getPlaceholderName() === "Vanity.player.tags") {
            $v = Vanity::getVanity($e->getMember()->getPlayer());
            $tag = !!$v[0] ? " " . $v[0] : "";
            $e->setValue((string) $tag);
        }
    }

    public function onMove(PlayerMoveEvent $e): void {
        $p = $e->getPlayer();
        if (isset($this->plugin::$TASKS[strtolower($p->getName())])) {
            /** @var Task */
            $task = $this->plugin::$TASKS[strtolower($p->getName())];
            $this->plugin->getScheduler()->scheduleTask($task);
        }
    }
}