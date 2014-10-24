<?php

namespace Dwr\AvatarBundle\Model;

abstract class Avatar {
    
    /**
     * @param int $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }
    
    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }
    
    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }
    
    /**
     * @return string
     */
    public function render()
    {
        return base64_encode($this->getContent());
    }
    
    private function getContent()
    {
        if($this->content){
            return $this->content;
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
     * @return Avatar
     */
    abstract public function getAvatar();
    
    /**
     * @return string
     */
    abstract protected function draw();

}
