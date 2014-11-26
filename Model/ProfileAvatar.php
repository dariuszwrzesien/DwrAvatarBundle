<?php

namespace Dwr\AvatarBundle\Model;

class ProfileAvatar extends Avatar {
    
    
    const FIELDS_DIVISION_PARTS = 5;
    
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
        $imageCellSize = $this->getSize()/self::FIELDS_ARRAY_DIMENSION;
        $imageColor = $this->randomizeColor($this->canvas, Avatar::$GREY);
        
        //function colorize avatar by mapping $fields to resource
            
        $counter = 0;
        $coordinates = array(
            'x1' => 0, 'y1' => 0, 
            'x2' => $imageCellSize, 'y2' => $imageCellSize,
        );
        
        foreach($imageMapFields as $field){
            if($counter < 5){
                if($field){
                    $this->filledRectangle($coordinates, $imageColor);
                }
                $coordinates['x1'] += $imageCellSize;
                $coordinates['x2'] += $imageCellSize;
            }
            if ($counter == 5){
                $coordinates = array(
                    'x1' => 0, 'y1' => $imageCellSize, 
                    'x2' => $imageCellSize, 'y2' => 2*$imageCellSize,
                );                  
                if($field){
                    $this->filledRectangle($coordinates, $imageColor);
                }
            }
            if($counter > 5 && $counter < 10){

                $coordinates['x1'] += $imageCellSize;
                $coordinates['x2'] += $imageCellSize;

                if($field){
                    $this->filledRectangle($coordinates, $imageColor);
                }

            }
            if ($counter == 10){
                $coordinates = array(
                    'x1' => 0, 'y1' => 2*$imageCellSize, 
                    'x2' => $imageCellSize, 'y2' => 3*$imageCellSize,
                );                  
                if($field){
                    $this->filledRectangle($coordinates, $imageColor);
                }
            }
            if($counter > 10 && $counter < 15){

                $coordinates['x1'] += $imageCellSize;
                $coordinates['x2'] += $imageCellSize;

                if($field){
                    $this->filledRectangle($coordinates, $imageColor);
                }

            }

            if ($counter == 15){
                $coordinates = array(
                    'x1' => 0, 'y1' => 3*$imageCellSize, 
                    'x2' => $imageCellSize, 'y2' => 4*$imageCellSize,
                );                  
                if($field){
                    $this->filledRectangle($coordinates, $imageColor);
                }
            }
            if($counter > 15 && $counter < 20){

                $coordinates['x1'] += $imageCellSize;
                $coordinates['x2'] += $imageCellSize;

                if($field){
                    $this->filledRectangle($coordinates, $imageColor);
                }

            }
            if ($counter == 20){
                $coordinates = array(
                    'x1' => 0, 'y1' => 4*$imageCellSize, 
                    'x2' => $imageCellSize, 'y2' => 5*$imageCellSize,
                );                  
                if($field){
                    $this->filledRectangle($coordinates, $imageColor);
                }
            }
            if($counter > 20 && $counter < 25){

                $coordinates['x1'] += $imageCellSize;
                $coordinates['x2'] += $imageCellSize;

                if($field){
                    $this->filledRectangle($coordinates, $imageColor);
                }

            }
            $counter++;

        }
    }
    
    /**
     * @param resource $canvas
     * @param array $mixColor
     * @return int
     */
    private function randomizeColor($canvas, $mixColor)
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
    
    private function filledRectangle(array $coordinates, $color)
    {
        imagefilledrectangle(
            $this->canvas, 
            $coordinates['x1'], 
            $coordinates['y1'], 
            $coordinates['x2'], 
            $coordinates['y2'], 
            $color
        );
    }
    
    /**
     * @return array
     */
    private function randomFillIn()
    {
        /**
         * Output: $random = array(
         *             array((bool)rand(0,1), (bool)rand(0,1)),
         *             array((bool)rand(0,1), (bool)rand(0,1)),
         *             array((bool)rand(0,1), (bool)rand(0,1))
         *             array((bool)rand(0,1), (bool)rand(0,1))
         *             array((bool)rand(0,1), (bool)rand(0,1))
         *         );
         */
        $random = array();
        for($i = 0; $i < 5; $i++){
            for($j = 0; $j < 2; $j++){
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
