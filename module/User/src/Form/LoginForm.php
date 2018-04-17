<?php
namespace User\Form;
use Zend\Form\Form;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilter;
/**
 * This form is used to collect user's login, password and 'Remember Me' flag.
 */
class LoginForm extends Form
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Define form name
        parent::__construct('login-form');
        
        // Set POST method for this form
        $this->setAttribute('method', 'post');
        
        $this->addElements();
        $this->addInputFilter();
    }
    
    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements()
    {
        // Add "email" field
        $this->add([
            'type'  => 'text',
            'name' => 'userName',
            'options' => [
                'label' => 'Your name',
            ],
        ]);
        
        // Add "password" field
        $this->add([
            'type'  => 'password',
            'name' => 'password',
            'options' => [
                'label' => 'Password',
            ],
        ]);      
        
        // Add the Submit button
        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Sign in',
                'id' => 'submit',
            ],
        ]);
    }
    
    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter()
    {
        // Create main input filter
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);
        
        // Add input for "userName" field
        $inputFilter->add([
            'name'     => 'userName',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
        ]);
        
        // Add input for "password" field
        $inputFilter->add([
            'name'     => 'password',
            'required' => true,
            'filters'  => [
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 3,
                        'max' => 64
                    ],
                ],
            ],
        ]);
    }
}