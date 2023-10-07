<?php

namespace Intervention\Image\Tests\Drivers\Gd;

use GdImage;
use Intervention\Image\Drivers\Gd\Image;
use Intervention\Image\Drivers\Gd\ImageFactory;
use Intervention\Image\Tests\TestCase;

/**
 * @requires extension gd
 * @covers \Intervention\Image\Drivers\Gd\ImageFactory
 */
class ImageFactoryTest extends TestCase
{
    public function testNewImage(): void
    {
        $factory = new ImageFactory();
        $image = $factory->newImage(3, 2);
        $this->assertInstanceOf(Image::class, $image);
    }

    public function testNewAnimation(): void
    {
        $factory = new ImageFactory();
        $image = $factory->newAnimation(function ($animation) {
            $animation->add($this->getTestImagePath('blue.gif'), 1.2);
            $animation->add($this->getTestImagePath('red.gif'), 1.2);
        });
        $this->assertInstanceOf(Image::class, $image);
        $this->assertEquals(2, $image->count());
    }

    public function testNewCore(): void
    {
        $factory = new ImageFactory();
        $core = $factory->newCore(3, 2);
        $this->assertInstanceOf(GdImage::class, $core);
    }
}
