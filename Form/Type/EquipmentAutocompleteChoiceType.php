<?php

declare(strict_types=1);

namespace Owl\Bundle\EquipmentBundle\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\ResourceAutocompleteChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class EquipmentAutocompleteChoiceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'resource' => 'owl.equipment',
            'choice_name' => 'name',
            'choice_value' => 'id',
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['remote_criteria_type'] = 'contains';
        $view->vars['remote_criteria_name'] = 'phrase';
    }

    /**
     * @psalm-return 'owl_equipment_autocomplete_choice'
     */
    public function getBlockPrefix(): string
    {
        return 'owl_equipment_autocomplete_choice';
    }

    /**
     * @psalm-return ResourceAutocompleteChoiceType::class
     */
    public function getParent(): string
    {
        return ResourceAutocompleteChoiceType::class;
    }
}
