<?php

declare(strict_types=1);

namespace App\Bundles\SingleSignOnBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class LoadSingleSignOnProvidersCompilerPass
 *
 * @package App\Bundles\SingleSignOnBundle\DependencyInjection\CompilerPass
 */
class LoadSingleSignOnProvidersCompilerPass implements CompilerPassInterface
{
    /**
     * Configure the container, so it will add available providers whenever the SingleSignOnContext object is created.
     *
     * Providers should be tagged with "single_sign_on.provider"
     *
     * @param ContainerBuilder $container
     * @return void
     */
    public function process(ContainerBuilder $container): void
    {
        $context = $container->findDefinition('single_sign_on.context');
        $taggedServices = $container->findTaggedServiceIds('single_sign_on.provider');

        foreach ($taggedServices as $id => $tags) {
            $context->addMethodCall('addProvider', [new Reference($id)]);
        }
    }
}
