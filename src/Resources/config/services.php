<?php

declare(strict_types=1);

use Adeliom\EasyMediaBundle\Controller\MediaController;
use Adeliom\EasyMediaBundle\EventListener\DoctrineMappingListener;
use Adeliom\EasyMediaBundle\EventListener\FolderSubscriber;
use Adeliom\EasyMediaBundle\EventListener\MediaSubscriber;
use Adeliom\EasyMediaBundle\Form\EasyMediaType;
use Adeliom\EasyMediaBundle\Imagine\Data\EasyMediaDataLoader;
use Adeliom\EasyMediaBundle\Service\EasyMediaHelper;
use Adeliom\EasyMediaBundle\Service\EasyMediaManager;
use Adeliom\EasyMediaBundle\Twig\EasyMediaExtension as EasyMediaTwigExtension;
use Adeliom\EasyMediaBundle\Twig\EasyMediaRuntime;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {
    $services = $container->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
    ;

    $services->set('easy_media.controller', MediaController::class)
        ->public()
        ->args([
            '$manager' => service('easy_media.manager'),
        ])
        ->tag('controller.service_arguments')
    ;
    $services->alias(MediaController::class, 'easy_media.controller')->public();

    $services->set('easy_media.manager', EasyMediaManager::class)
        ->public()
        ->args([
            '$filesystem' => service('easy_media.storage'),
            '$helper' => service('easy_media.helper'),
            '$em' => service('doctrine.orm.entity_manager'),
            '$parameters' => service('parameter_bag'),
            '$translator' => service('translator'),
        ])
    ;
    $services->alias(EasyMediaManager::class, 'easy_media.manager')->public();

    $services->set('easy_media.helper', EasyMediaHelper::class)
        ->public()
        ->args([
            '$parameters' => service('parameter_bag'),
            '$em' => service('doctrine.orm.entity_manager'),
        ])
    ;
    $services->alias(EasyMediaHelper::class, 'easy_media.manager')->public();

    $services->set('easy_media.form.media', EasyMediaType::class)
        ->public()
        ->args([
            '$manager' => service('easy_media.manager'),
        ])
    ;

    $services->set('easy_media.event_listener.doctrine_mapping_listener', DoctrineMappingListener::class)
        ->public()
        ->args([
            '%easy_media.media_entity%',
            '%easy_media.folder_entity%',
        ])
        ->tag('doctrine.event_listener', ['event' => 'loadClassMetadata'])
    ;

    $services->set('easy_media.twig.easy_media_extension', EasyMediaTwigExtension::class)
        ->public()
        ->args([
            '$manager' => service('easy_media.manager'),
        ])
        ->tag('twig.extension')
    ;

    $services->set('easy_media.twig.easy_media_runtime', EasyMediaRuntime::class)
        ->public()
        ->args([
            '$manager' => service('easy_media.manager'),
            '$twig' => service('twig'),
            '$filterManager' => service('liip_imagine.filter.manager'),
        ])
        ->tag('twig.runtime')
    ;

    $services->set('easy_media.imagine.data.loader', EasyMediaDataLoader::class)
        ->public()
        ->args([
            service('easy_media.storage'),
            service('liip_imagine.extension_guesser'),
        ])
        ->tag('liip_imagine.binary.loader', ['loader' => 'easy_media_data_loader'])
    ;

    $services->set('easy_media.event_listener.folder', FolderSubscriber::class)
        ->public()
        ->args([
            '$manager' => service('easy_media.manager'),
        ])
        ->tag('doctrine.event_listener', ['event' => 'preUpdate'])
    ;

    $services->set('easy_media.event_listener.media', MediaSubscriber::class)
        ->public()
        ->args([
            '$manager' => service('easy_media.manager'),
        ])
        ->tag('doctrine.event_listener', ['event' => 'preUpdate'])
    ;
};
