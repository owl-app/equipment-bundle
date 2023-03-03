<?php

declare(strict_types=1);

namespace Owl\Bundle\EquipmentBundle;

use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;

final class OwlEquipmentBundle extends AbstractResourceBundle
{
    public function getSupportedDrivers(): array
    {
        return [
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
        ];
    }

    /**
     * @psalm-suppress MismatchingDocblockReturnType https://github.com/vimeo/psalm/issues/2345
     */
    protected function getModelNamespace(): string
    {
        return 'Owl\Component\Equipment\Model';
    }
}
