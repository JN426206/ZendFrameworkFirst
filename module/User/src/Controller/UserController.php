<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Model\UserTable;
use User\Model\User;

class UserController extends AbstractActionController
{
    
    private $table;
    public function __construct(UserTable $table)
    {
        $this->table = $table;
    }
    
    public function indexAction()
    {
        $users = $this->table->fetchAll();
        return ['users' => $users, 'dupa' => 'dupa2'];
    }
}
