<?php

declare(strict_types=1);

namespace Esites\RecaptchaBundle\DependencyInjection;

use Esites\RecaptchaBundle\Constants\ConfigConstants;
use Exception;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class EsitesRecaptchaExtension extends Extension
{
    /**
     * @throws Exception
     */
    public function load(
        array $configs,
        ContainerBuilder $container
    ): void {
        $configuration = new Configuration();
        $processor = new Processor();

        $config = $processor->processConfiguration(
            $configuration,
            $configs
        );

        foreach (ConfigConstants::getConfigKeys() as $configKey) {
            $container->setParameter(
                ConfigConstants::getParameterKeyName(
                    $configKey
                ),
                $config[$configKey]
            );
        }

        $loader = new Loader\YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yml');
    }
}
