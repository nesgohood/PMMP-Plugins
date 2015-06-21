<?php

/**
 * @author ChalkPE <amato0617@gmail.com>
 * @since 2015-06-21 16:36
 */

namespace chalk\cameraman\task;

use chalk\cameraman\Camera;
use chalk\cameraman\Cameraman;
use pocketmine\scheduler\PluginTask;

class CameraTask extends PluginTask {
    /** @var Camera */
    private $camera;

    /** @var int */
    private $i = 0;

    function __construct(Camera $camera){
        parent::__construct(Cameraman::getInstance());
        $this->camera = $camera;
    }

    /**
     * @param $currentTick
     */
    public function onRun($currentTick){
        if($this->i >= count($this->getCamera()->getMovements())){
            $this->getCamera()->stop();
            return;
        }

        $position = $this->getCamera()->getMovements()[$this->i]->tick($this->getCamera()->getSlowness());
        if($position === false){
            $this->i++;
            return;
        }

        $target = $this->getCamera()->getTarget();

        $target->setPosition($position); //FIXME: WHY DIDN'T UPDATE IN CLIENT?
        $target->getLevel()->addEntityMovement( $target->chunk->getX(), $target->chunk->getZ(), $target->getId(),
                                                $target->getX(), $target->getY(), $target->getZ(),
                                                $target->getYaw(), $target->getPitch());
    }

    /**
     * @return Camera
     */
    public function getCamera(){
        return $this->camera;
    }
}