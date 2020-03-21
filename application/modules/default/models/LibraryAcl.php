<?php
class Model_LibraryAcl extends Zend_Acl
{
    public function __construct ()
    {
        $this->addRole(new Zend_Acl_Role('guests'));
        $this->addRole(new Zend_Acl_Role('payer'), 'guests');
        $this->addRole(new Zend_Acl_Role('users'), 'payer');
        $this->addRole(new Zend_Acl_Role('admins'), 'users');
        $this->add(new Zend_Acl_Resource('library'))->add(
        new Zend_Acl_Resource('library:books'), 'library')
        ->add(
        new Zend_Acl_Resource('library:Languageswitch'), 'library');
        $this->addResource(new Zend_Acl_Resource('admin'))->add(
        new Zend_Acl_Resource('admin:book'), 'admin')->add(
        new Zend_Acl_Resource('admin:users'), 'admin');
        $this->addResource(new Zend_Acl_Resource('default'))
            ->add(new Zend_Acl_Resource('default:autentication'), 
        'default')
            ->add(new Zend_Acl_Resource('default:index'), 'default')
            ->add(new Zend_Acl_Resource('default:error'), 'default');
            
        $this->allow('guests', 'default:index', array('index','contests','games','referee','game','live','put'));  
        $this->allow('guests', 'library:books', 'list');   
        $this->allow('guests', 'default:index', 'list');  
        $this->allow('guests','admin:book',array('index'));
        $this->allow('guests','admin:users',array('profile'));
        $this->allow('guests', 'default:autentication', 'signup');
        $this->allow('guests', 'default:autentication', 'login');
        $this->allow('guests', 'default:autentication', 'refresh');
        $this->allow('guests', 'default:error', 'error');
        $this->allow('guests', 'library:Languageswitch', 'switch');
        $this->deny('payer', 'default:autentication', 'signup');
        $this->deny('payer', 'default:autentication', 'login');
        $this->allow('payer', 'default:index', 'index');
        $this->allow('payer', 'default:autentication', 'logout');
        $this->allow('payer', 'default:index', 'pay');
        $this->allow('users', 'admin:users', 'edit');
        $this->allow('users', 'library:books', array('index', 'list','view'));
        $this->allow('admins', 'admin:users', 'list');
        $this->deny('admins', 'default:index','list');
        //$this->allow('admins', 'default:index','game'); 
        $this->allow('admins', 'admin:users',array('index','pay','delete','list'));
        $this->allow('admins', 'admin:book', array('add', 'player', 'delete','finis'));
    }
}