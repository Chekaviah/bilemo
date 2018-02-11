<?php

namespace App\Tests\Entity;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;

/**
 * Class ProductTest
 *
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 */
class ProductTest extends TestCase
{
    public function testAttributes()
    {
        $product = new Product();
        $product->setName('name');
        $product->setDescription('description');
        $product->setPrice('99.99');

        static::assertNull($product->getId());
        static::assertEquals('name', $product->getName());
        static::assertEquals('description', $product->getDescription());
        static::assertEquals(99.99, $product->getPrice());
    }
}