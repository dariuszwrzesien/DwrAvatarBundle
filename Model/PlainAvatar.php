<?php

namespace Dwr\AvatarBundle\Model;

class PlainAvatar extends Avatar {
    
    /**
     * @var int 
     */
    protected $width;
    
    /**
     * @var int 
     */
    protected $height;
    
    /**
     * @var string 
     */
    protected $content;

    /**
     * @param int $width
     * @param int $height
     */
    public function __construct($width, $height) 
    {
        $this->width = $width;
        $this->height = $height;
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
        $resource = imagecreatetruecolor($this->getWidth(), $this->getHeight());
        $color = $this->randomizeColor($resource);
        imagefill($resource, 0, 0, $color);
        
        ob_start(); 
            imagejpeg($resource);
            $image = ob_get_contents(); 
        ob_end_clean();
        
        $this->content = $image;
        
        return $this->content;
    }
    
    /**
     * @param resource $resource
     * @return int 
     */
    private function randomizeColor($resource)
    {
        // Mixing random colors with white (255, 255, 255) creates neutral pastels 
        // by increasing the lightness while keeping the hue of the original color. 
        
        $mix = ['r' => 255, 'g' => 255, 'b' => 255]; // white
        
        $red   = (rand(0, 255) + $mix['r']) /2;
        $green = (rand(0, 255) + $mix['g']) /2;
        $blue  = (rand(0, 255) + $mix['b']) /2;
        
        return imagecolorallocate($resource, $red, $green, $blue);
    }
    
}
