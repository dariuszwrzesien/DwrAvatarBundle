<?php

namespace Dwr\AvatarBundle\Model;

use PHPUnit_Framework_TestCase;

class PlainAvatarTest extends PHPUnit_Framework_TestCase
{
    public function testGetAvatar()
    {
        $plainAvatar = new PlainAvatar(50, 50);
        $result = $plainAvatar->getAvatar();
        
        $this->assertInstanceOf(
            'Dwr\AvatarBundle\Model\Avatar', 
            $result
        );
    }
}
