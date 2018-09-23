<?php

namespace Artist;


use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\ArtistTable::class => function($container) {
                    $tableGateway = $container->get(Model\ArtistTableGateway::class);
                    return new Model\ArtistTable($tableGateway);
                },
                Model\ArtistTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Artist());
                    return new TableGateway('artist', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\ArtistController::class => function($container) {
                    return new Controller\ArtistController(
                        $container->get(Model\ArtistTable::class)
                    );
                },
            ],
        ];
    }


}