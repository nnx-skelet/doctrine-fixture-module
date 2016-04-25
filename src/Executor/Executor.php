<?php
/**
 * @link    https://github.com/nnx-framework/doctrine-fixture-module
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\DoctrineFixtureModule\Executor;

use Doctrine\Fixture\Loader\Loader;
use Doctrine\Fixture\Filter\Filter;
use Doctrine\Fixture\Configuration;
use Doctrine\Fixture\Loader\ChainLoader;
use Doctrine\Fixture\Filter\ChainFilter;
use Doctrine\Fixture\Executor as FixtureExecutor;

/**
 * Class Executor
 *
 * @package Nnx\DoctrineFixtureModule\Executor
 */
class Executor implements ExecutorInterface
{
    /**
     * Загрузчик фикстур
     *
     * @var Loader
     */
    protected $loader;

    /**
     * Фильтр фикстур
     *
     * @var Filter
     */
    protected $filter;

    /**
     * Конфигурация компонета отвечающего за выполнение фикстур
     *
     * @var Configuration
     */
    protected $configuration;

    /**
     * Компонент отвечающий за выполение фикстур
     *
     * @var FixtureExecutor
     */
    protected $fixtureExecutor;

    /**
     * Имя
     *
     * @var string
     */
    protected $name = Executor::class;

    /**
     * Сервис, отвечающий за создание компонента выполняющего фикстуры
     *
     *
     * @var FixtureExecutorBuilderInterface
     */
    protected $fixtureExecutorBuilder;

    /**
     * Executor constructor.
     *
     * @param Configuration                   $configuration
     * @param FixtureExecutorBuilderInterface $fixtureExecutorBuilder
     */
    public function __construct(Configuration $configuration, FixtureExecutorBuilderInterface $fixtureExecutorBuilder)
    {
        $this->setConfiguration($configuration);
        $this->setFixtureExecutorBuilder($fixtureExecutorBuilder);
    }

    /**
     * Возвращает компонент отвечающий за выполение фикстур
     *
     * @return FixtureExecutor
     */
    public function getFixtureExecutor()
    {
        if (null !== $this->fixtureExecutor) {
            $this->fixtureExecutor;
        }
        $configuration = $this->getConfiguration();
        $this->fixtureExecutor = $this->getFixtureExecutorBuilder()->build($configuration, $this);

        return $this->fixtureExecutor;
    }

    /**
     * Возвращает загрузчик фикстур
     *
     * @return Loader
     */
    public function getLoader()
    {
        if (null === $this->loader) {
            $this->loader = new ChainLoader();
        }
        return $this->loader;
    }

    /**
     * Устанавливает загрузчик фикстур
     *
     * @param Loader $loader
     *
     * @return $this
     */
    public function setLoader(Loader $loader)
    {
        $this->loader = $loader;

        return $this;
    }

    /**
     * Возвращает фильтр фикстур
     *
     * @return Filter
     */
    public function getFilter()
    {
        if (null === $this->filter) {
            $this->filter = new ChainFilter();
        }
        return $this->filter;
    }

    /**
     * Устанавливает фильтр фикстур
     *
     * @param Filter $filter
     *
     * @return $this
     */
    public function setFilter(Filter $filter)
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * Возвращает конфигурацию компонета отвечающего за выполнение фикстур
     *
     * @return Configuration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * Устанавливает конфигурацию компонета отвечающего за выполнение фикстур
     *
     * @param Configuration $configuration
     *
     * @return $this
     */
    public function setConfiguration(Configuration $configuration)
    {
        $this->configuration = $configuration;

        return $this;
    }



    /**
     * @inheritdoc
     *
     * @return void
     */
    public function import()
    {
        $loader = $this->getLoader();
        $filter = $this->getFilter();

        $this->getFixtureExecutor()->execute($loader, $filter, FixtureExecutor::IMPORT);
    }


    /**
     * @inheritdoc
     *
     * @return void
     */
    public function purge()
    {
        $loader = $this->getLoader();
        $filter = $this->getFilter();

        $this->getFixtureExecutor()->execute($loader, $filter, FixtureExecutor::PURGE);
    }

    /**
     * Возвращает имя
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Устанавливает имя
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = (string)$name;

        return $this;
    }

    /**
     * Возвращает сервис, отвечающий за создание компонента выполняющего фикстуры
     *
     * @return FixtureExecutorBuilderInterface
     */
    public function getFixtureExecutorBuilder()
    {
        return $this->fixtureExecutorBuilder;
    }

    /**
     * Устанавливает сервис, отвечающий за создание компонента выполняющего фикстуры
     *
     * @param FixtureExecutorBuilderInterface $fixtureExecutorBuilder
     *
     * @return $this
     */
    public function setFixtureExecutorBuilder(FixtureExecutorBuilderInterface $fixtureExecutorBuilder)
    {
        $this->fixtureExecutorBuilder = $fixtureExecutorBuilder;

        return $this;
    }
}