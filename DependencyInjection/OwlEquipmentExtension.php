<?php

declare(strict_types=1);

namespace Owl\Bundle\EquipmentBundle\DependencyInjection;

use Owl\Bundle\EquipmentBundle\Controller\EquipmentAttributeController;
use Owl\Bundle\EquipmentBundle\Doctrine\ORM\EquipmentAttributeValueRepository;
use Owl\Bundle\EquipmentBundle\Form\Type\EquipmentAttributeTranslationType;
use Owl\Bundle\EquipmentBundle\Form\Type\EquipmentAttributeType;
use Owl\Bundle\EquipmentBundle\Form\Type\EquipmentAttributeValueType;
use Owl\Component\Equipment\Model\EquipmentAttribute;
use Owl\Component\Equipment\Model\EquipmentAttributeInterface;
use Owl\Component\Equipment\Model\EquipmentAttributeTranslation;
use Owl\Component\Equipment\Model\EquipmentAttributeTranslationInterface;
use Owl\Component\Equipment\Model\EquipmentAttributeValue;
use Owl\Component\Equipment\Model\EquipmentAttributeValueInterface;
use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class OwlEquipmentExtension extends AbstractResourceExtension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration($this->getConfiguration([], $container), $configs);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $this->registerResources('owl', $config['driver'], $config['resources'], $container);

        $loader->load('services.xml');
    }

    public function prepend(ContainerBuilder $container): void
    {
        $config = $this->processConfiguration(new Configuration(), $container->getExtensionConfig($this->getAlias()));

        $this->prependAttribute($container, $config);
    }

    private function prependAttribute(ContainerBuilder $container, array $config): void
    {
        if (!$container->hasExtension('owl_attribute')) {
            return;
        }

        $container->prependExtensionConfig('owl_attribute', [
            'resources' => [
                'equipment' => [
                    'subject' => $config['resources']['equipment']['classes']['model'],
                    'attribute' => [
                        'classes' => [
                            'model' => EquipmentAttribute::class,
                            'interface' => EquipmentAttributeInterface::class,
                            'controller' => EquipmentAttributeController::class,
                            'form' => EquipmentAttributeType::class,
                        ],
                        // 'translation' => [
                        //     'classes' => [
                        //         'model' => EquipmentAttributeTranslation::class,
                        //         'interface' => EquipmentAttributeTranslationInterface::class,
                        //         'form' => EquipmentAttributeTranslationType::class,
                        //     ],
                        // ],
                    ],
                    'attribute_value' => [
                        'classes' => [
                            'model' => EquipmentAttributeValue::class,
                            'interface' => EquipmentAttributeValueInterface::class,
                            'repository' => EquipmentAttributeValueRepository::class,
                            'form' => EquipmentAttributeValueType::class,
                        ],
                    ],
                ],
            ],
        ]);
    }
}
