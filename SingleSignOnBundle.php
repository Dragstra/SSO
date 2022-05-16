<?php

declare(strict_types=1);

namespace App\Bundles\SingleSignOnBundle;

use App\Bundles\SingleSignOnBundle\DependencyInjection\Compiler\LoadSingleSignOnProvidersCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class SingleSignOnBundle
 *
 * @package App\Bundles\SingleSignOnBundle
 */
class SingleSignOnBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new LoadSingleSignOnProvidersCompilerPass());
    }
}
