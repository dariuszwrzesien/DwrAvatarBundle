<?php

namespace Dwr\AvatarBundle\Model;

abstract class Generator 
{
    /**
     * @param Avatar $avatar
     */
    protected abstract function factory(Avatar $avatar);

    /**
     * @param Avatar $avatar
     * @return Avatar
     */
    public function generate(Avatar $avatar) {
        
        return $this->factory($avatar);
    }

}
