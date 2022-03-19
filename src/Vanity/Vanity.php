<?php declare(strict_types=1);

namespace Vanity;

use pocketmine\player\Player;
use pocketmine\utils\Config;

final class Vanity {
    private static Loader $plugin;
    
    public static function new(Loader $plugin) {
        self::$plugin = $plugin;
    }

    public static function writePlayer(Player $player): void {
        $config = new Config(self::$plugin->getDataFolder() . strtolower($player->getName()) . ".yml");
        $config->set("tag", "");
        $config->set("particle", "");
        $config->save();
    }
    
    public static function saveTag(Player $player, string $tag): void {
        if(!self::exists($player)) {
            self::writePlayer($player);
        }
        $config = new Config(self::$plugin->getDataFolder() . strtolower($player->getName()) . ".yml");
        $config->set("tag", $tag);
        $config->save();
    }
    
    public static function saveParticle(Player $player, string $particle): void {
        if(!self::exists($player)) {
            self::writePlayer($player);
        }
        $config = new Config(self::$plugin->getDataFolder() . strtolower($player->getName()) . ".yml");
        $config->set("particle", $particle);
        $config->save();
    }

    /**
     * API:
     * 0 -> Tag
     * 1 -> Particle
     */
    public static function getVanity(Player $player): array {
        if(!self::exists($player)) {
            self::writePlayer($player);
        }
        $config = new Config(self::$plugin->getDataFolder() . strtolower($player->getName()) . ".yml");
        $tag = $config->get('tag');
        $particle = $config->get('particle');
        return [$tag, $particle];
    }

    public static function exists(Player $player): bool {
        return is_file(self::$plugin->getDataFolder() . strtolower($player->getName()) . ".yml");
    }
}