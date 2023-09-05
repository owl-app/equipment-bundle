<?php

declare(strict_types=1);

namespace Owl\Bundle\EquipmentBundle\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\MoneyBundle\Form\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class EquipmentType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'owl.form.common.name',
            ])
            ->add('symbol', TextType::class, [
                'required' => false,
                'label' => 'owl.form.common.symbol',
            ])
            ->add('unit', TextType::class, [
                'required' => false,
                'label' => 'owl.form.common.unit',
            ])
            ->add('price', MoneyType::class, [
                'required' => false,
                'label' => 'owl.form.common.price',
                'currency' => $options['currency'] ?? null,
                'empty_data'  => '0'
            ])
            ->add('other', TextType::class, [
                'required' => false,
                'label' => 'owl.form.common.other',
            ])
            ->add('attributes', CollectionType::class, [
                'entry_type' => EquipmentAttributeValueType::class,
                'required' => false,
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false,
            ])
        ;
    }

    /**
     * @return string
     *
     * @psalm-return 'owl_equipment'
     */
    public function getBlockPrefix(): string
    {
        return 'owl_equipment';
    }
}
