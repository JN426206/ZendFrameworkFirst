<?php
namespace User\Controller\Factory;
use Interop\Container\ContainerInterface;
use User\Controller\AuthController;
use Zend\ServiceManager\Factory\FactoryInterface;
use User\Service\AuthManager;
use User\Model\UserTable;
/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class AuthControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $userTable = $container->get(UserTable::class);
        $authManager = $container->get(AuthManager::class);
        return new AuthController($userTable, $authManager);
    }
}