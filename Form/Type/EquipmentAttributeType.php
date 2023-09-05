<?php

declare(strict_types=1);

namespace Owl\Bundle\EquipmentBundle\Form\Type;

use Owl\Bundle\AttributeBundle\Form\Type\AttributeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class EquipmentAttributeType extends AttributeType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('name', TextType::class, [
                'label' => 'owl.form.common.name',
            ])
            ->add('position', IntegerType::class, [
                'required' => false,
                'label' => 'owl.form.equipment_attribute.position',
                'invalid_message' => 'owl.equipment_attribute.invalid',
            ])
        ;
    }

    /**
     * @return string
     *
     * @psalm-return 'owl_equipment_attribute'
     */
    public function getBlockPrefix(): string
    {
        return 'owl_equipment_attribute';
    }
}
