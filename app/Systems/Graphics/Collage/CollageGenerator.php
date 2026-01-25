<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Systems\Graphics\Collage;

use Closure;
use Illuminate\Support\Collection;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use App\Systems\Graphics\Collage\Exceptions\ImageCountException;
use App\Systems\Graphics\Collage\Helpers\Config;
use App\Systems\Graphics\Collage\Helpers\File;

abstract class CollageGenerator
{
    /**
     * @var File
     */
    protected $file;

    /**
     * @var Collection
     */
    protected $images;

    /**
     * CollageGenerator constructor.
     *
     * @param File $file
     * @param Config $config
     */
    public function __construct(File $file, Config $config)
    {
        $this->file = $file;
        $this->transformFiles();
    }

    /**
     * @param Closure $closure
     *
     * @return Image
     */
    abstract public function create($closure = null);

    /**
     * Set file transformations.
     */
    protected function transformFiles()
    {

        $manager = new ImageManager(Driver::Class);

        $images = [];
        foreach ($this->file->getFiles() as $file) {
            if ($file instanceof Image) {
                $images[] = $file;
            } else {
                $images[] = $manager->read(_file_get_contents($file));
            }
        }

        $this->images = $images;
    }

    /**
     * @param int $count
     * @throws ImageCountException
     * @return void
     */
    protected function check($count)
    {
        $files = count($this->images);
        if ($files != $count) {
            $message = "Cannot create collage of {$count} image with {$files} image(s)";

            throw new ImageCountException($message);
        }
    }
}
