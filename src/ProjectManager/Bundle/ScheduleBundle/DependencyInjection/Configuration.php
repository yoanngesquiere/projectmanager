<?php

namespace ProjectManager\Bundle\ScheduleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('project_manager_schedule')->children()
            ->integerNode('first_weekday')
                ->defaultValue(1)
                ->min(0)
                ->max(6)
            ->end()
            ->arrayNode('non_working_days')
                ->prototype('scalar')
                ->end()
            ->end()
            ->booleanNode('display_non_working_days')
            ->end();

        return $treeBuilder;
    }
}
