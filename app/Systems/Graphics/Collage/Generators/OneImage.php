<?php

namespace App\Systems\Graphics\Collage\Generators;

use Closure;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use App\Systems\Graphics\Collage\CollageGenerator;

class OneImage extends CollageGenerator
{
    /**
     * @var Image
     */
    protected $canvas;

    /**
     * @param Closure $closure
     *
     * @return \Intervention\Image\Image
     */
    public function create($closure = null)
    {
        $this->check(1);

        $this->createCanvas();
        $this->process();

        return $this->canvas->place($this->images[0], 'center');
    }

    /**
     * Create the Outer canvas.
     */
    protected function createCanvas()
    {
        $width = $this->file->getWidth();
        $height = $this->file->getHeight();
        $color = $this->file->getColor();

        $manager = new ImageManager(Driver::Class);

        $this->canvas = $manager->create($width, $height)->fill($color);
    }

    /**
     * Process Image.
     */
    protected function process()
    {
        $width = $this->file->getWidth() - $this->file->getPadding();
        $height = $this->file->getHeight() - $this->file->getPadding();

        $this->images = [$this->images[0]->cover($width, $height)];
    }
}
