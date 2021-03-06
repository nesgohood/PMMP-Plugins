<?php

/*
 * Copyright 2015 ChalkPE
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * @author ChalkPE <amato0617@gmail.com>
 * @since 2015-05-23 12:01
 */

namespace chalk\clannish\command\management;

use chalk\clannish\clan\ClanMember;
use chalk\clannish\Clannish;
use chalk\clannish\command\InGameCommand;
use pocketmine\command\CommandSender;

class DelegateManagerCommand extends ManagementCommand implements InGameCommand {
    public function __construct(Clannish $plugin, $name, $description = "", $usage = ""){
        parent::__construct($plugin, $name, $description, $usage);
    }

    /**
     * @param CommandSender $sender
     * @param string[] $args
     * @return bool
     */
    public function exec(CommandSender $sender, array $args){
        if(count($args) < 2 or !is_string($args[0]) or !is_string($args[1])){
            return false;
        }

        $clanName = Clannish::validateName($args[0], true);
        $managerName = Clannish::validateName($sender->getName());
        $memberName = Clannish::validateName($args[1]);

        $clan = Clannish::getInstance()->getClan($clanName);

        if($clan === null){
            $this->sendMessage($sender, "clan-not-found", ["name" => $clanName]);
            return true;
        }

        if(!($clan->getMember($managerName)->isManager() or $sender->hasPermission("clannish.operation"))){
            $this->sendMessage($sender, "clan-manager-only");
            return true;
        }

        if(!$clan->isMember($memberName)){
            $this->sendMessage($sender, "clan-member-not-found", ["name" => $memberName]);
            return true;
        }

        $clan->getManager()->setGrade(ClanMember::GRADE_STAFF);
        $clan->getMember($memberName)->setGrade(ClanMember::GRADE_MANAGER);

        $this->sendMessage($sender, "clan-manager-delegated", ["name" => $clanName, "member" => $memberName]);
        return true;
    }
}