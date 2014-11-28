<?php

namespace Dwr\AvatarBundle\Model;

abstract class Avatar {
    
    public static $WHITE = ['r' => 255, 'g' => 255, 'b' => 255];
    public static $GREY  = ['r' => 100, 'g' => 100, 'b' => 100];
    
    /**
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }
    
    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function render()
    {
        return base64_encode($this->getPicture());
    }
    
    private function getPicture()
    {
        if($this->picture){
            return $this->picture;
        }
        
        return $this->draw();
    }
    
    /**
     * @param string $directory
     * @param mixed $filename
     * @return \SplFileObject
     */
    public function save($directory, $filename = null)
    {
        $filename = $directory . $this->createFileName($filename);
        $file = new \SplFileObject($filename, 'x');
        $file->fwrite(base64_decode($this->render()));
        
        return $file;
    }
    
    private function createFileName($filename)
    {
        if ($filename){
            return $filename;
        }
        
        $filename = date('YmdHis') . uniqid() . '.jpg';
        
        return $filename;
    }
    
    /**
     * @param resource $canvas
     * @param array $mixColor
     * @return int
     */
    protected function randomizeColor($canvas, $mixColor)
    {
        /**
         * MixColor:
         * Mixing random colors with white (255, 255, 255) creates neutral pastels 
         * by increasing the lightness while keeping the hue of the original color. 
         * $mixColor = ['r' => 255, 'g' => 255, 'b' => 255]; // white
         */
        
        $red   = (rand(100, 255) + $mixColor['r']) /2;
        $green = (rand(100, 255) + $mixColor['g']) /2;
        $blue  = (rand(100, 255) + $mixColor['b']) /2;
        
        return imagecolorallocate($canvas, $red, $green, $blue);
    }
    
    /**
     * @return Avatar
     */
    abstract public function getAvatar();
    
    /**
     * @return string
     */
    abstract protected function draw();

}
