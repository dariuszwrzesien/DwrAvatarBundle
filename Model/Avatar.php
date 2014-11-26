<?php

namespace Dwr\AvatarBundle\Model;

abstract class Avatar {
    
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
     * @return Avatar
     */
    abstract public function getAvatar();
    
    /**
     * @return string
     */
    abstract protected function draw();

}
