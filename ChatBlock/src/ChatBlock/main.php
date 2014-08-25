<?php

namespace ChatBlock;

use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;
use pocketmine\command\Command;

Class main extends PluginBase implements Listener{
        public $temp = array();
    
    public function onLoad(){
    }
    
    public function onEnable(){
    $this->getLogger()->info(TextFormat::DARK_BLUE ."ChatBlock Enabled!");
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    
    public function onChat(PlayerChatEvent $event){
            $message = $event->getMessage();
            $sender = $event->getPlayer()->getName();
            $recipients = $event->getRecipients();
            $event->setCancelled();
            foreach($recipients as $x) {
                $s = $x->getName();
                if (isset($this->temp[$s])){
                    unset($recipients[$x]);
                }
            }
            foreach($recipients as $i) {
                $i->sendMessage("<" . $sender . "> " . $message);
            }
    }
    
    public function onCommand(CommandSender $sender, Command $command, $label, array $args) {
        switch ($command) {
        case "mute":
            $player = $sender->getName();
            $this->temp[$player] = $player;
            $sender->sendMessage("[ChatBlock] Your chat has been muted!");
            $sender->sendMessage("[ChatBlock] You will cease to recieve chat messages");
            break;
        
        case "unmute";
            $player = $sender->getName();
            unset($this->temp[$player]);
            $sender->sendMessage("[ChatBlock] Your chat has been unmuted");
        }       
    }
}