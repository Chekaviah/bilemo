<?php

namespace App\Swagger;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class SwaggerDecorator
 *
 * @author Mathieu GUILLEMINOT <guilleminotm@gmail.com>
 */
final class SwaggerDecorator implements NormalizerInterface
{
    private $decorated;

    public function __construct(NormalizerInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function normalize($object, $format = null, array $context = array())
    {
        $docs = $this->decorated->normalize($object, $format, $context);

        $clientsGetParameters = array(
            [
                'name' => 'user_id',
                'in' => 'query',
                'required' => true,
                'type' => 'integer',
                'description' => 'Filter clients by user id. You can see only your own clients.'
            ],
            [
                'name' => 'page',
                'in' => 'query',
                'required' => false,
                'type' => 'integer',
                'description' => 'The collection page number. 25 clients are displayed per page.'
            ]
        );

        $docs['paths']['/api/clients']['get']['parameters'] = $clientsGetParameters;

        return $docs;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $this->decorated->supportsNormalization($data, $format);
    }
}
