<?php

namespace Dwr\AvatarBundle\Model;

use Exception;

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
    public function generate(Avatar $avatar) 
    {
        if ( ! extension_loaded('gd')) {
            throw new Exception('Your PHP installation doesn\'t have GD extension loaded.');
        }
        
        return $this->factory($avatar);
    }

}
