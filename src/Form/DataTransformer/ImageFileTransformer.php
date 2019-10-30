<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class ImageFileTransformer implements DataTransformerInterface
{

    public function transform($file): array
    {
        return [
            'file' => null,
            'fileName' => $file
        ];
    }

    public function reverseTransform($data)
    {
        return $data['fileName'];
    }

}
