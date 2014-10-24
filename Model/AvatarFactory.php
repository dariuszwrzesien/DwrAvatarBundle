<?php

namespace Dwr\AvatarBundle\Model;

class AvatarFactory extends Generator
{
    /**
     * @var Avatar
     */
    private $avatar;
    
    /**
     * @param Avatar $avatar
     * @return Avatar
     */
    protected function factory(Avatar $avatar)
    {
        $this->avatar = $avatar;
        
        return $this->avatar->getAvatar();
    }

}
