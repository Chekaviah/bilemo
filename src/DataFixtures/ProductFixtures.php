<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class ProductFixtures
 *
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 */
class ProductFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->getNames() as $name) {
            $product = new Product();
            $product->setName($name);
            $product->setDescription($this->getRandomText());
            $product->setPrice(number_format(mt_rand(5000, 50000)/100, 2, '.', ''));

            $manager->persist($product);
        }

        $manager->flush();
    }

    private function getNames(): array
    {
        $names = [];
        $i = 0;
        while ($i < 200) {
            $name = rand(10000, 99999);
            if (!in_array($name, $names)) {
                $names[] = 'Téléphone X-'.$name;
                $i++;
            }
        }

        return $names;
    }

    private function getPhrases(): array
    {
        return [
            'Lorem ipsum dolor sit amet consectetur adipiscing elit',
            'Pellentesque vitae velit ex',
            'Mauris dapibus risus quis suscipit vulputate',
            'Eros diam egestas libero eu vulputate risus',
            'In hac habitasse platea dictumst',
            'Morbi tempus commodo mattis',
            'Ut suscipit posuere justo at vulputate',
            'Ut eleifend mauris et risus ultrices egestas',
            'Aliquam sodales odio id eleifend tristique',
            'Urna nisl sollicitudin id varius orci quam id turpis',
            'Nulla porta lobortis ligula vel egestas',
            'Curabitur aliquam euismod dolor non ornare',
            'Sed varius a risus eget aliquam',
            'Nunc viverra elit ac laoreet suscipit',
            'Pellentesque et sapien pulvinar consectetur',
            'Ubi est barbatus nix',
            'Abnobas sunt hilotaes de placidus vita',
            'Ubi est audax amicitia',
            'Eposs sunt solems de superbus fortis',
            'Vae humani generis',
            'Diatrias tolerare tanquam noster caesium',
            'Teres talis saepe tractare de camerarius flavum sensorem',
            'Silva de secundus galatae demitto quadra',
            'Sunt accentores vitare salvus flavum parses',
            'Potus sensim ad ferox abnoba',
            'Sunt seculaes transferre talis camerarius fluctuies',
            'Era brevis ratione est',
            'Sunt torquises imitari velox mirabilis medicinaes',
            'Mineralis persuadere omnes finises desiderium',
            'Bassus fatalis classiss virtualiter transferre de flavum',
        ];
    }

    private function getRandomText(int $maxLength = 255): string
    {
        $phrases = $this->getPhrases();
        shuffle($phrases);
        while (mb_strlen($text = implode('. ', $phrases).'.') > $maxLength) {
            array_pop($phrases);
        }
        return $text;
    }
}
