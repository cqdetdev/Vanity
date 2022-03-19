<?php declare(strict_types=1);

namespace Vanity\commands;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Bread;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as C;
use ReflectionProperty;
use Vanity\Loader;
use Vanity\Tags;
use Vanity\Vanity;

class TagCommand extends Command {
    private Loader $main;

    public function __construct(Loader $plugin) {
        parent::__construct("tags", "A command to manage tags", "tags");
        $this->main = $plugin;
        $this->setPermission("tags");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if($sender instanceof Player) {
            $form = new SimpleForm(function(Player $player, $data) {
                if(!$data) return;
                if(!is_string($data)) return;
                if($data !== "remove") {
                    $s = constant("Vanity\Tags::$data");
                    Vanity::saveTag($player, $s);
                    $player->sendTip(C::GREEN . "Successfully changed tag");
                } else {
                    Vanity::saveTag($player, "");
                    $player->sendMessage(C::GREEN . "Successfully removed tag");
                    return;
                }
            });
            $form->setTitle("§9§lTags");
            $form->addButton("GOD: " . Tags::GOD, -1, "", "GOD");
            $form->addButton("PVP: " . Tags::PVP, -1, "", "PVP");
            $form->addButton("PLUS: " . Tags::PLUS, -1 , "", "PLUS");
            $form->addButton("COMBOS: " . Tags::COMBOS, -1, "", "COMBOS");
            $form->addButton("L: " . Tags::L, -1, "", "L");
            $form->addButton("HEART: " . Tags::HEART, -1, "", "HEART");
            $form->addButton("NOOB: " . Tags::NOOB, -1, "", "NOOB");
            $form->addButton("BOWSPAMMER: " . Tags::BOW_SPAMMER, -1, "", "BOWSPAMMER");
            $form->addButton("SPEEDRUNNER: " . Tags::SPEED_RUNNER, -1, "", "SPEEDRUNNER");
            $form->addButton("ADDICTED: " . Tags::ADDICTED, -1, "", "ADDICTED");
            $form->addButton("BAGUETTE: " . Tags::BAGUETTE, -1, "", "BAGUETTE");

            $form->addButton("Remove Tags", -1 , "", "remove");
            $sender->sendForm($form);
            return true;
        } else {
            $sender->sendMessage("Please use this command in-game");
            return false;
        }
    }
}