<?php

declare(strict_types=1);

namespace Owl\Bundle\EquipmentBundle\Form\Type;

use Owl\Bundle\AttributeBundle\Form\Type\AttributeChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\Options;

final class EquipmentAttributeChoiceType extends AttributeChoiceType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'choices' => function (Options $options) {
                    return !is_null($options['category']) ? $this->attributeRepository->findByCategory($options['category']) : [];
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
