<?php

namespace Gregwar\ImageBundle\Extensions;

use Gregwar\ImageBundle\ImageHandler;
use Gregwar\ImageBundle\Services\ImageHandling;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * ImageTwig extension.
 *
 * @author Gregwar <g.passault@gmail.com>
 * @author bzikarsky <benjamin.zikarsky@perbility.de>
 */
class ImageTwig extends AbstractExtension
{
    /**
     * @var ImageHandling
     */
    private $imageHandling;

    /**
     * @var string
     */
    private $webDir;

    public function __construct(ImageHandling $imageHandling, string $webDir)
    {
        $this->imageHandling = $imageHandling;
        $this->webDir = $webDir;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('image', [$this, 'image'], ['is_safe' => ['html']]),
            new TwigFunction('new_image', [$this, 'newImage'], ['is_safe' => ['html']]),
            new TwigFunction('web_image', [$this, 'webImage'], ['is_safe' => ['html']]),
        ];
    }

    public function webImage(string $path): ImageHandler
    {
        $directory = sprintf('%s/%s', $this->webDir, $path);

        return $this->imageHandling->open($directory);
    }

    /**
     * @param string $path
     *
     * @return ImageHandler
     */
    public function image(string $path): ImageHandler
    {
        return $this->imageHandling->open($path);
    }

    /**
     * @param string $width
     * @param string $height
     *
     * @return ImageHandler
     */
    public function newImage(string $width, string $height): ImageHandler
    {
        return $this->imageHandling->create($width, $height);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'image';
    }
}
