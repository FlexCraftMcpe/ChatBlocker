<?php
namespace chatblock;

use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\Listener;
use pocketmine\command\Command;

class Main extends PluginBase implements Listener{
    public $temp = [];
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    public function onChat(PlayerChatEvent $event){
        $recipients = $event->getRecipients();
        for($i = 0; $i < count($recipients); $i++) {
            if (isset($this->temp[$recipients[$i]->getName()])){
                unset($recipients[$i]);
            }
        }
        $event->setRecipients($recipients);
    }
    public function onCommand(CommandSender $sender, Command $command, $label, array $args) {
        switch ($command->getName()) {
            case "mute":
                $player = $sender->getName();
                $this->temp[$player] = true;
                $sender->sendMessage("[ChatBlock] Your chat has been muted!");
                $sender->sendMessage("[ChatBlock] You will cease to receive chat messages.");
                break;
            case "unmute";
                $player = $sender->getName();
                unset($this->temp[$player]);
                $sender->sendMessage("[ChatBlock] Your chat has been unmuted.");
                break;
        }       
    }
}