<?php declare(strict_types=1);

namespace Vanity\tasks;

use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use pocketmine\world\particle\HeartParticle;
use pocketmine\world\particle\LavaParticle;
use pocketmine\world\particle\WaterParticle;

class DisplayPlayerParticleTask extends Task {
    private Player $player;
    private string $particle;

    public function __construct(Player $player, string $particle) {
        $this->player = $player;
        $this->particle = $particle;
    }

    public function onRun(): void {
        $pos = $this->player->getPosition();
        $p = constant("Vanity\Particles::{$this->particle}");
        $this->player->getWorld()->addParticle(new Vector3($pos->x, $pos->y - 0.5, $pos->z), $p);
    }
}