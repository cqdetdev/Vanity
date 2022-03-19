<?php declare(strict_types=1);

namespace Vanity\commands;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as C;
use Vanity\Loader;
use Vanity\tasks\DisplayPlayerParticleTask;
use Vanity\Vanity;

class ParticleCommand extends Command {
    private Loader $main;

    public function __construct(Loader $plugin) {
        parent::__construct("particles", "A command to manage particles", "particle");
        $this->main = $plugin;
        $this->setPermission("particles");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if($sender instanceof Player) {
            $form = new SimpleForm(function(Player $player, $data) {
                if(!$data) return;
                if(!is_string($data)) return;
                if($data !== "remove") {
                    if(isset($this->main::$TASKS[strtolower($player->getName())])) {
                        unset($this->main::$TASKS[strtolower($player->getName())]);
                    }
                    $this->main::$TASKS[strtolower($player->getName())] = new DisplayPlayerParticleTask($player, $data);
                    Vanity::saveParticle($player, $data);
                    $player->sendTip(C::GREEN . 'Successfully enabled particles');
                } else {
                    if(isset($this->main::$TASKS[strtolower($player->getName())])) {
                        unset($this->main::$TASKS[strtolower($player->getName())]);
                        Vanity::saveParticle($player, "");
                        $player->sendTip(C::GREEN . 'Successfully removed particles');
                    } else {
                        $player->sendTip(C::GOLD . 'You don\'t have particles enabled');
                    }
                }
            });
            $form->setTitle("§9§lTags");
            $form->addButton("§6§lLava", -1, "", "LAVA");
            $form->addButton("§1§lWater", -1, "", "WATER");
            $form->addButton("§4§lHearts", -1, "", "HEARTS");
            $form->addButton("Remove Particles", -1, "", "remove");

            $sender->sendForm($form);
            return true;
        } else {
            $sender->sendMessage("Please use this command in-game");
            return false;
        }
    }
}