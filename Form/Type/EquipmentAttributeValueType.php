<?php

declare(strict_types=1);

namespace Owl\Bundle\EquipmentBundle\Form\Type;

use Owl\Bundle\AttributeBundle\Form\Type\AttributeValueType;

final class EquipmentAttributeValueType extends AttributeValueType
{
    /**
     * @psalm-return 'sylius_product_attribute_value'
     */
    public function getBlockPrefix(): string
    {
        return 'sylius_product_attribute_value';
    }
}
