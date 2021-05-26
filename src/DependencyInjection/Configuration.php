<?php

declare(strict_types=1);

namespace Esites\RecaptchaBundle\DependencyInjection;

use Esites\RecaptchaBundle\Constants\ConfigConstants;
use Esites\RecaptchaBundle\Constants\RecaptchaConstants;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('esites_recaptcha');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
            ->booleanNode(ConfigConstants::CONFIG_ENABLE_RECAPTCHA)
                ->defaultTrue()
            ->end()
            ->scalarNode(ConfigConstants::CONFIG_RECAPTCHA_KEY)
                ->isRequired()
            ->end()
            ->scalarNode(ConfigConstants::CONFIG_RECAPTCHA_SECRET)
                ->isRequired()
            ->end()
            ->floatNode(ConfigConstants::CONFIG_RECAPTCHA_SCORE)
                ->defaultValue(RecaptchaConstants::DEFAULT_RECAPTCHA_SCORE)
            ->end()
            ->scalarNode(ConfigConstants::CONFIG_EXPECTED_HOSTNAME)
                ->defaultValue(null)
            ->end()
            ->booleanNode(ConfigConstants::CONFIG_USE_CLIENT_IP)
                ->defaultTrue()
            ->end()
        ;

        return $treeBuilder;
    }
}
