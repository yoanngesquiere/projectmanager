<?php

namespace ProjectManager\Bundle\ScheduleBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ProjectManagerScheduleExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $this->processConfiguration($configuration, $configs);

        $config = array();
        foreach ($configs as $subConfig) {
            $config = array_merge($config, $subConfig);
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('pm_first_weekday', $config['first_weekday']);
        $container->setParameter('pm_non_working_days', $config['non_working_days']);
        $container->setParameter('pm_display_non_working_days', $config['display_non_working_days']);
    }
}
