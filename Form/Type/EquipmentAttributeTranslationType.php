<?php

declare(strict_types=1);

namespace Owl\Bundle\EquipmentBundle\Form\Type;

use Owl\Bundle\AttributeBundle\Form\Type\AttributeTranslationType;

final class EquipmentAttributeTranslationType extends AttributeTranslationType
{
    public function getBlockPrefix(): string
    {
        return 'sylius_product_attribute_translation';
    }
}
