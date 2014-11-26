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
        $white = ['r' => 255, 'g' => 255, 'b' => 255];
        $backgroundColor = $this->randomizeColor($this->canvas, $white);
        imagefill($this->canvas, 0, 0, $backgroundColor);
    }
    
    /**
     * @param resource $resource
     * @param array $mixColor
     * @return int 
     */
    private function randomizeColor($resource, array $mixColor)
    {
        /**
         * Mixing random colors with white (255, 255, 255) creates neutral pastels
         * by increasing the lightness while keeping the hue of the original color.
         * $mix = ['r' => 255, 'g' => 255, 'b' => 255]; // white
         */
        
        $red   = (rand(0, 255) + $mixColor['r']) /2;
        $green = (rand(0, 255) + $mixColor['g']) /2;
        $blue  = (rand(0, 255) + $mixColor['b']) /2;
        
        return imagecolorallocate($resource, $red, $green, $blue);
    }
}
