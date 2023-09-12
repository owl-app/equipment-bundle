<?php

declare(strict_types=1);

namespace Owl\Bundle\EquipmentBundle\Form\Type;

use Owl\Bundle\AttributeBundle\Form\Type\AttributeChoiceType;
use Owl\Bundle\CoreBundle\Doctrine\ORM\EquipmentAttributeRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\Options;

final class EquipmentAttributeChoiceType extends AttributeChoiceType
{
    public function __construct(private EquipmentAttributeRepository $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'choices' => function (Options $options) {
                    if(!is_null($options['category'])) {
                        return  $this->attributeRepository->findByCategory($options['category'])->getQuery()->getResult();
                    }

                    return $this->attributeRepository->findAll();
                },
                'choice_value' => 'code',
                'choice_label' => 'name',
                'choice_translation_domain' => false,
                'category' => null
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_product_attribute_choice';
    }
}
