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
 * @since 2015-04-08 19:06
 * @copyright Apache-v2.0
 */
namespace chalk\clannish;

use pocketmine\command\PluginCommand;

abstract class ClannishCommand extends PluginCommand {
    /**
     * @param Clannish $plugin
     * @param string $name
     * @param string $description
     * @param string $permission
     * @param string $usage
     */
    public function __construct(Clannish $plugin, $name, $description = "", $permission = "", $usage = ""){
        parent::__construct($name, $plugin);

        $this->setDescription($description);
        $this->setPermission($permission);
        $this->setUsage($usage);
    }
}