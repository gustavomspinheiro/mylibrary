<?php


namespace Source\Support;


use CoffeeCode\Cropper\Cropper;

class Thumb
{
    /*** @var*/
    private $cropper;

    /*** @var*/
    private $uploads;


    /**
     * Thumb constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->cropper = (new Cropper(CONF_CACHE_IMG_PATH, CONF_CACHE_IMG_QUALITY['jpg'], CONF_CACHE_IMG_QUALITY['png']));
        $this->uploads = CONF_UPLOAD_DIR;
    }

    /**
     * Responsible for making image cache.
     * @param string $image
     * @param int $width
     * @param int|null $height
     * @return string
     */
    public function make(string $image, int $width, ?int $height = null): string
    {
        return $this->cropper->make("{$this->uploads}/{$image}", $width, $height);
    }

    /**
     * Responsible for cleaning the cache.
     * @param string|null $image
     */
    public function flush(?string $image): void
    {
        if($image){
            $this->flush($image);
            return;
        }

        $this->flush();
        return;
    }

    /**
     * @return Cropper
     */
    public function cropper(): Cropper
    {
        return $this->cropper;
    }
}