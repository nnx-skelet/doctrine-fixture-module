<?php
/**
 * @link    https://github.com/nnx-framework/doctrine-fixture-module
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\DoctrineFixtureModule\Filter;

use Nnx\DoctrineFixtureModule\FilterUsedFixtureService\FilterUsedFixtureServiceInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\MutableCreationOptionsInterface;
use Zend\ServiceManager\MutableCreationOptionsTrait;
use Zend\ServiceManager\ServiceLocatorInterface;


/**
 * Class FilterUsedFixtureFactory
 *
 * @package Nnx\DoctrineFixtureModule\Filter
 */
class FilterUsedFixtureFactory
    implements FactoryInterface, MutableCreationOptionsInterface
{
    use MutableCreationOptionsTrait;

    /**
     * @inheritDoc
     * @throws \Nnx\DoctrineFixtureModule\Filter\Exception\RuntimeException
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $creationOptions = $this->getCreationOptions();
        if (!array_key_exists('contextExecutor', $creationOptions)) {
            $errMsg = 'Context executor not specified';
            throw new Exception\RuntimeException($errMsg);
        }

        $appServiceLocator = $serviceLocator;
        if ($serviceLocator instanceof AbstractPluginManager) {
            $appServiceLocator = $serviceLocator->getServiceLocator();
        }

        /** @var FilterUsedFixtureServiceInterface $filterUsedFixtureService */
        $filterUsedFixtureService = $appServiceLocator->get(FilterUsedFixtureServiceInterface::class);


        return new FilterUsedFixture($creationOptions['contextExecutor'], $filterUsedFixtureService);
    }
}
