<?php

namespace Dwr\AvatarBundle\Model;

use PHPUnit_Framework_TestCase;

class PlainAvatarTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Avatar
     */
    private $plainAvatar;
    
    public function setUp() {
        parent::setUp();
        $this->plainAvatar = new PlainAvatar(1, 1);
    }
    
    public function testGetAvatar()
    {   
        $this->assertInstanceOf(
            'Dwr\AvatarBundle\Model\Avatar', 
            $this->plainAvatar->getAvatar()
        );
    }
    
    public function testRenderReturnsBase64Stream()
    {   
        $this->assertFalse(!base64_decode($this->plainAvatar->render(), true));
    }
    
    public function testSaveReturnFile()
    {
        $file = $this->plainAvatar->save(__DIR__);
        
        $this->assertTrue($file->isFile(), 'File Expected');
        $this->assertFileExists($file->getPathname(), 'File doesn\'t exits');
        unlink($file->getRealPath());
    }
    
    public function testSaveReturnCorrectFilename()
    {
        $filename = 'image.jpg';
        $file = $this->plainAvatar->save(__DIR__.'/', $filename);
        
        $this->assertSame($filename, $file->getFilename());
        $this->assertFileExists($file->getPathname(), 'File doesn\'t exits');
        unlink($file->getRealPath());
    }
    
    public function testSettersAndGetters()
    {
        $this->plainAvatar->setWidth(5);
        $this->plainAvatar->setHeight(5);
        
        $this->assertSame(5, $this->plainAvatar->getWidth());
        $this->assertSame(5, $this->plainAvatar->getHeight());
    }
    
}
