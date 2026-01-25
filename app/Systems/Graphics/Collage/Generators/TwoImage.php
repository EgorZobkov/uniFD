<?php

namespace App\Systems\Graphics\Collage\Generators;

use Closure;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use App\Systems\Graphics\Collage\CollageGenerator;

class TwoImage extends CollageGenerator
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
        $this->check(2);

        $this->createCanvas();
        $this->makeSelection($closure);

        $manager = new ImageManager(Driver::Class);

        return $manager->create(
            $this->file->getWidth(),
            $this->file->getHeight(),
        )->fill($this->file->getColor())->place($this->canvas, 'center');
    }

    /**
     * Create inner canvas.
     */
    protected function createCanvas()
    {
        $height = $this->file->getHeight() - $this->file->getPadding();
        $width = $this->file->getWidth() - $this->file->getPadding();

        $manager = new ImageManager(Driver::Class);

        $this->canvas = $manager->create($width, $height);
    }

    /**
     * Process Vertical
     */
    public function vertical()
    {
        $this->resizeVerticalImages();

        $this->canvas->place($this->images[0]);
        $this->canvas->place($this->images[1], 'top-right');
    }

    /**
     * Process Horizontal.
     */
    public function horizontal()
    {
        $this->resizeHorizontalImages();

        $this->canvas->place($this->images[0]);
        $this->canvas->place($this->images[1], 'bottom-left');
    }

    /**
     * @param Closure $closure
     */
    protected function makeSelection($closure = null)
    {
        if ($closure) {
            call_user_func($closure, $this);
        } else {
            $this->horizontal();
        }
    }

    /**
     * Resize Images for Horizontal Use.
     */
    protected function resizeHorizontalImages()
    {
        $height = $this->file->getHeight() / 2 - ceil($this->file->getPadding() * 0.75);

        $images = [];
        foreach ($this->images as $image) {
            $images[] = $image->cover($this->file->getWidth() - $this->file->getPadding(), $height);
        }

        $this->images = $images;
    }

    /**
     * Resize Images for Vertical Use.
     */
    protected function resizeVerticalImages()
    {
        $width = $this->file->getWidth() / 2 - ceil($this->file->getPadding() * 0.75);
        $images = [];
        foreach ($this->images as $image) {
            $images[] = $image->cover($width, $this->file->getHeight() - $this->file->getPadding());
        }

        $this->images = $images;
    }
}
