<?php

namespace Dwr\AvatarBundle\Model;

class ProfileAvatar extends Avatar {
    
    
    const PROFILE_IMAGE_RESOLUTION = 5;
    
    /**
     * @var int 
     */
    protected $size;
    
    /**
     * @var string 
     */
    protected $picture;
    
    /**
     * @var string
     */
    protected $canvas;

    /**
     * @param int $size
     */
    public function __construct($size) 
    {
        $this->size = $size;
        $this->canvas = imagecreatetruecolor($size, $size);
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
        $this->createProfileImage();
        
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
    
    private function createProfileImage()
    {
        $imageMapFields = $this->randomFillIn();
        $imageCellSize = $this->getSize()/self::PROFILE_IMAGE_RESOLUTION;
        $imageColor = $this->randomizeColor($this->canvas, Avatar::$GREY);
        
        $coordinates = array(
            'x1' => 0, 'y1' => 0, 
            'x2' => $imageCellSize, 'y2' => $imageCellSize,
        );
        
        $counter = 0;
        foreach ($imageMapFields as $field) {
            if ($counter % 5 !== 0) {
                $coordinates['x1'] += $imageCellSize;
                $coordinates['x2'] += $imageCellSize;
                $this->filledRectangle($coordinates, $imageColor, $field);
            } else {
                if ($counter > 0) {
                    $coordinates = array(
                        'x1' => 0, 'y1' => $coordinates['y1'] += $imageCellSize, 
                        'x2' => $imageCellSize, 'y2' => $coordinates['y2'] += $imageCellSize,
                    );
                }
                $this->filledRectangle($coordinates, $imageColor, $field);
            }
            $counter++;
        }
    }
    
    private function filledRectangle(array $coordinates, $color, $field)
    {
        if ($field) {
            imagefilledrectangle(
                $this->canvas, 
                $coordinates['x1'], 
                $coordinates['y1'], 
                $coordinates['x2'], 
                $coordinates['y2'], 
                $color
            );
        }
    }
    
    /**
     * @return array
     */
    private function randomFillIn()
    {
        /**
         * Output: 
         * $random = array(
         *     array((bool)rand(0,1), (bool)rand(0,1)),
         *     array((bool)rand(0,1), (bool)rand(0,1)),
         *     array((bool)rand(0,1), (bool)rand(0,1))
         *     array((bool)rand(0,1), (bool)rand(0,1))
         *     array((bool)rand(0,1), (bool)rand(0,1))
         * );
         */
        $random = array();
        for ($i = 0; $i < self::PROFILE_IMAGE_RESOLUTION; $i++) {
            for ($j = 0; $j < 2; $j++) {
               $random[$i][$j] = (bool)rand(0,1);
            }
        }
        
        $filledInFields = array(
            $random[0][0], $random[0][1], !$random[0][1], $random[0][1], $random[0][0],
            $random[1][0], $random[1][1], !$random[1][1], $random[1][1], $random[1][0],
            $random[2][0], $random[2][1], !$random[2][1], $random[2][1], $random[2][0],
            $random[3][0], $random[3][1], !$random[3][1], $random[3][1], $random[3][0],
            $random[4][0], $random[4][1], !$random[4][1], $random[4][1], $random[4][0],
        );
            
        return $filledInFields;
    }
    
}
