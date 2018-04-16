<?php 
namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Auth\Model\AuthTable;
use Auth\Form\AuthForm;
use Auth\Model\Auth;


class AuthController extends AbstractActionController
{
    
    private $table;
    public function __construct(AuthTable $table)
    {
        $this->table = $table;
    }
    
    public function indexAction()
    {
        $form = new AuthForm();
        $form->get('submit')->setValue('Login');
        
        $request = $this->getRequest();
        
        if (! $request->isPost()) {
            return ['form' => $form];
        }
        
        $auth = new Auth();
        $form->setInputFilter($auth->getInputFilter());
        $form->setData($request->getPost());
        
        if (! $form->isValid()) {
            return ['form' => $form];
        }
        
        echo $form->get('userName')->getValue();
        
        $row = $this->table->getAuthPassByUserName($form->get('userName')->getValue());
        
        if($row != null)
            print_r($row);
        
        $viewModel = new ViewModel();
        $viewModel->setVariable('loged', true);
        
        return $viewModel;
    }
    
    public function loginAction()
    {
        return new ViewModel();
    }
}