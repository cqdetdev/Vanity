<?php declare(strict_types=1);

namespace Vanity;

use pocketmine\world\particle\HeartParticle;
use pocketmine\world\particle\LavaParticle;
use pocketmine\world\particle\WaterParticle;

class Tags {
    public const LAVA = new LavaParticle;
    public const WATER = new WaterParticle;
    public const HEARTS = new HeartParticle;
}