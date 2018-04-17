<?php
namespace User\Model\Factory;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use User\Controller\UserController;
use User\Model\UserTable;
use User\Model\UserTableGateway;
/**
 * This is the factory for UserController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class UserTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $tableGateway = $container->get(UserTableGateway::class);
        
        // Instantiate the controller and inject dependencies
        return new UserTable($tableGateway);
    }
}