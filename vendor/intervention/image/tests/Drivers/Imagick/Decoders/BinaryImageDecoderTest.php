<?php

namespace Intervention\Image\Tests\Drivers\Imagick\Decoders;

use Intervention\Image\Drivers\Imagick\Decoders\BinaryImageDecoder;
use Intervention\Image\Drivers\Imagick\Image;
use Intervention\Image\Tests\TestCase;

class BinaryImageDecoderTest extends TestCase
{
    public function testDecodePng(): void
    {
        $decoder = new BinaryImageDecoder();
        $image = $decoder->decode(file_get_contents($this->getTestImagePath('tile.png')));
        $this->assertInstanceOf(Image::class, $image);
        $this->assertEquals(16, $image->getWidth());
        $this->assertEquals(16, $image->getHeight());
        $this->assertCount(1, $image);
    }

    public function testDecodeGif(): void
    {
        $decoder = new BinaryImageDecoder();
        $image = $decoder->decode(file_get_contents($this->getTestImagePath('red.gif')));
        $this->assertInstanceOf(Image::class, $image);
        $this->assertEquals(16, $image->getWidth());
        $this->assertEquals(16, $image->getHeight());
        $this->assertCount(1, $image);
    }

    public function testDecodeAnimatedGif(): void
    {
        $decoder = new BinaryImageDecoder();
        $image = $decoder->decode(file_get_contents($this->getTestImagePath('cats.gif')));
        $this->assertInstanceOf(Image::class, $image);
        $this->assertEquals(75, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
        $this->assertCount(4, $image);
    }

    public function testDecodeJpegWithExif(): void
    {
        $decoder = new BinaryImageDecoder();
        $image = $decoder->decode(file_get_contents($this->getTestImagePath('exif.jpg')));
        $this->assertInstanceOf(Image::class, $image);
        $this->assertEquals(16, $image->getWidth());
        $this->assertEquals(16, $image->getHeight());
        $this->assertCount(1, $image);
        $this->assertEquals('Oliver Vogel', $image->getExif('IFD0.Artist'));
    }
}