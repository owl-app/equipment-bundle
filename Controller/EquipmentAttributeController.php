<?php

declare(strict_types=1);

namespace Owl\Bundle\EquipmentBundle\Controller;

use Owl\Bridge\SyliusResource\Controller\BaseController;
use Owl\Bundle\EquipmentBundle\Form\Type\EquipmentAttributeChoiceType;
use Owl\Component\Core\Model\EquipmentAttributeInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class EquipmentAttributeController extends BaseController
{
    public function getAttributeTypesAction(Request $request, string $template): Response
    {
        return $this->render(
            $template,
            [
                'types' => $this->get('sylius.registry.attribute_type')->all(),
                'metadata' => $this->metadata,
            ]
        );
    }

    public function renderAttributesAction(Request $request): Response
    {
        $template = $request->attributes->get('template', '@SyliusAttribute/attributeChoice.html.twig');
        $categoryId = $request->query->get('categoryId');

        $form = $this->get('form.factory')->create(EquipmentAttributeChoiceType::class, null, [
            'multiple' => true,
            'category' => $categoryId
        ]);

        return $this->render($template, ['form' => $form->createView()]);
    }

    public function renderAttributeValueFormsAction(Request $request): Response
    {
        $template = $request->attributes->get('template', '@SyliusAttribute/attributeValueForms.html.twig');
        $categoryId = $request->query->get('categoryId');

        $form = $this->get('form.factory')->create(EquipmentAttributeChoiceType::class, null, [
            'multiple' => true,
            'category' => $categoryId
        ]);
        $form->handleRequest($request);

        $attributes = $form->getData();
        if (null === $attributes) {
            throw new BadRequestHttpException();
        }

        $localeCodes = $this->get('sylius.translation_locale_provider')->getDefinedLocalesCodes();

        $forms = [];
        foreach ($attributes as $attribute) {
            $forms[$attribute->getCode()] = $this->getAttributeFormsInAllLocales($attribute, $localeCodes);
        }

        return $this->render($template, [
            'forms' => $forms,
            'count' => $request->query->get('count'),
            'metadata' => $this->metadata,
        ]);
    }

    /**
     * @param array|string[] $localeCodes
     *
     * @return FormView[]
     *
     * @psalm-return array{'': FormView}
     */
    protected function getAttributeFormsInAllLocales(EquipmentAttributeInterface $attribute, array $localeCodes): array
    {
        $attributeForm = $this->get('sylius.form_registry.attribute_type')->get($attribute->getType(), 'default');

        $forms = [];

        // if (!$attribute->isTranslatable()) {
        array_push($localeCodes, null);

        return [null => $this->createFormAndView($attributeForm, $attribute)];
        // }

        // foreach ($localeCodes as $localeCode) {
        //     $forms[$localeCode] = $this->createFormAndView($attributeForm, $attribute);
        // }

        // return $forms;
    }

    private function createFormAndView(
        $attributeForm,
        EquipmentAttributeInterface $attribute
    ): FormView {
        return $this
            ->get('form.factory')
            ->createNamed(
                'value',
                $attributeForm,
                null,
                ['label' => $attribute->getName(), 'configuration' => $attribute->getConfiguration()]
            )
            ->createView();
    }
}
