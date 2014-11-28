<?php

namespace Dwr\AvatarBundle\Model;

class PlainAvatar extends Avatar {
    
    /**
     * @var int 
     */
    protected $size;
    
    /**
     * @var string 
     */
    protected $picture;
    
    /**
     * @var resource
     */
    protected $canvas;
    

    /**
     * @param int $size
     */
    public function __construct($size) 
    {
        $this->size = $size;
        $this->canvas = imagecreatetruecolor($this->getSize(), $this->getSize());
    }
    
    /**
     * @return Avatar
     */
    public function getAvatar() 
    {
        return $this;
    }
    
    protected function draw()
    {
        $this->createBackground();
        
        ob_start(); 
            imagejpeg($this->canvas);
            $image = ob_get_contents(); 
        ob_end_clean();
        
        $this->picture = $image;
        
        return $this->picture;
    }
    
    private function createBackground()
    {
        $backgroundColor = $this->randomizeColor($this->canvas, Avatar::$WHITE);
        imagefill($this->canvas, 0, 0, $backgroundColor);
    }
    
}
