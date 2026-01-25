<?php

namespace App\Systems\Graphics\Collage\Generators;

use Closure;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use App\Systems\Graphics\Collage\CollageGenerator;

class FourImage extends CollageGenerator
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
        $this->check(4);

        $height = $this->file->getHeight() - $this->file->getPadding();
        $width = $this->file->getWidth() - $this->file->getPadding();

        $manager = new ImageManager(Driver::Class);

        $this->canvas = $manager->create($width, $height);

        $this->makeSelection($closure);

        return $manager->create(
            $this->file->getWidth(),
            $this->file->getHeight(),
        )->fill($this->file->getColor())->place($this->canvas, 'center');
    }

    /**
     * Align Image Horizontally.
     */
    public function horizontal()
    {
        $width = $this->file->getWidth() - $this->file->getPadding();
        $height = $this->file->getHeight() / 4 - $this->file->getPadding() * 0.75;

        $one = $this->images[0];
        $this->canvas->place($one->cover($width, floor($height)), 'top');

        $two = $this->images[1];
        $this->canvas->place($two->cover($width, floor($height)), 'top', 0, intval($this->file->getHeight() / 4));

        $three = $this->images[2];
        $this->canvas->place($three->cover($width, floor($height)), 'top', 0, intval($this->file->getHeight() / 2));

        $four = $this->images[3];
        $this->canvas->place($four->cover($width, floor($height)), 'bottom');
    }

    /**
     * Align Image Vertically.
     */
    public function vertical()
    {
        $width = $this->file->getWidth() / 4 - $this->file->getPadding() * 0.75;
        $height = $this->file->getHeight() - $this->file->getPadding();

        $one = $this->images[0];
        $this->canvas->place($one->cover(floor($width), $height), 'left');

        $two = $this->images[1];
        $this->canvas->place($two->cover(floor($width), $height), 'left', intval($this->file->getWidth() / 4));

        $three = $this->images[2];
        $this->canvas->place($three->cover(floor($width), $height), 'left', intval($this->file->getWidth() / 2));

        $four = $this->images[3];
        $this->canvas->place($four->cover(floor($width), $height), 'right');
    }

    /**
     * Process all images.
     */
    public function grid()
    {
        list($width, $height) = $this->getSmallSize();

        $one = $this->images[0];
        $this->canvas->place($one->cover($width, $height), 'top-left');

        $two = $this->images[1];
        $this->canvas->place($two->cover($width, $height), 'top-right');

        $three = $this->images[2];
        $this->canvas->place($three->cover($width, $height), 'bottom-left');

        $four = $this->images[3];
        $this->canvas->place($four->cover($width, $height), 'bottom-right');
    }

    /**
     * @param Closure $closure
     */
    protected function makeSelection($closure = null)
    {
        if ($closure) {
            call_user_func($closure, $this);
        } else {
            $this->grid();
        }
    }

    /**
     * @return array
     */
    protected function getSmallSize()
    {
        $width = $this->file->getWidth() / 2 - ceil($this->file->getPadding() * 0.75);
        $height = $this->file->getHeight() / 2 - ceil($this->file->getPadding() * 0.75);

        return [$width, $height];
    }
}
