<?php

namespace Dwr\AvatarBundle\Controller;

use Dwr\AvatarBundle\Model\AvatarFactory;
use Dwr\AvatarBundle\Model\PlainAvatar;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Example how to use.
 */
class DefaultController extends Controller
{
    /**
     * @Route("/avatar", name="avatar")
     * @Template()
     */
    public function indexAction()
    {
        
        $avatar = new AvatarFactory();
        $plainAvatar = $avatar->generate(new PlainAvatar(140));
        
        return array(
            'plainAvatar' => $plainAvatar->render()
        );
    }
}
