<?php

namespace App\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\{
    AbstractType,
    FormEvent,
    FormEvents,
    FormBuilderInterface
};
use Symfony\Component\Form\Extension\Core\Type\{
    FileType,
    HiddenType
};
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Form\DataTransformer\ImageFileTransformer;
use Symfony\Component\HttpFoundation\RequestStack;

class ImageFileType extends AbstractType
{

    private $request;

    public function __construct(RequestStack $request)
    {
        $this->request = $request;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fileOptions = [
            'label' => false,
            'required' => $options['required'] ?? true
        ];

        if (array_key_exists('sonata_help', $builder->getOptions()) && $options['file']) {
            $imgPath = substr($options['upload_path'], strpos($options['upload_path'], '/media'));
            $uploadUrl = $this->request->getCurrentRequest()->getUriForPath($imgPath);

            $fileOptions['sonata_help'] = '<img src="' . $uploadUrl . $options['file'] . '" height="auto" width="20%"/>';
        }

        $builder
            ->add('fileName', HiddenType::class)
            ->add('file', FileType::class, $fileOptions)
            ->addModelTransformer(new ImageFileTransformer())
            ->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) use ($options) {
                $data = $event->getData();
                if ($data['file'] instanceof UploadedFile) {
                    $fileName = md5(uniqid()) . '.' . $data['file']->guessClientExtension();
                    $data['file']->move($options['upload_path'], $fileName);
                    $data['fileName'] = $fileName;
                    $data['file'] = null;

                    $event->setData($data);
                }
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'upload_path',
            'file'
        ]);

        $resolver->setDefaults([
            'file' => null
        ]);
    }

}
