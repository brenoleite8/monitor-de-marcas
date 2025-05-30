<?php
/**
 * SystemUserForm
 *
 * @version    1.0
 * @package    control
 * @subpackage admin
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class SystemUserForm extends TPage
{
    protected $form; // form
    protected $program_list;
    
    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct()
    {
        parent::__construct();
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_System_user');
        $this->form->setFormTitle( _t('User') );

        // create the form fields
        $id            = new TEntry('id');
        $name          = new TEntry('name');
        $login         = new TEntry('login');
        $password      = new TPassword('password');
        $repassword    = new TPassword('repassword');
        $email         = new TEntry('email');
        $unit_id       = new TDBCombo('system_unit_id','permission','SystemUnit','id','name');
        $groups        = new TDBCheckGroup('groups','permission','SystemGroup','id','name');
        $frontpage_id  = new TDBUniqueSearch('frontpage_id', 'permission', 'SystemProgram', 'id', 'name', 'name');
        $units         = new TDBCheckGroup('units','permission','SystemUnit','id','name');
        
        $password->disableAutoComplete();
        $repassword->disableAutoComplete();
        
        $units->setLayout('horizontal');
        if ($units->getLabels())
        {
            foreach ($units->getLabels() as $label)
            {
                $label->setSize(200);
            }
        }
        
        $groups->setLayout('horizontal');
        if ($groups->getLabels())
        {
            foreach ($groups->getLabels() as $label)
            {
                $label->setSize(200);
            }
        }
        
        $btn = $this->form->addAction( _t('Save'), new TAction(array($this, 'onSave')), 'far:save');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addActionLink( _t('Clear'), new TAction(array($this, 'onEdit')), 'fa:eraser red');
        $this->form->addActionLink( _t('Back'), new TAction(array('SystemUserList','onReload')), 'far:arrow-alt-circle-left blue');
        
        // define the sizes
        $id->setSize('50%');
        $name->setSize('100%');
        $login->setSize('100%');
        $password->setSize('100%');
        $repassword->setSize('100%');
        $email->setSize('100%');
        $unit_id->setSize('100%');
        $frontpage_id->setSize('100%');
        $frontpage_id->setMinLength(1);
        
        // outros
        $id->setEditable(false);
        
        // validations
        $name->addValidation(_t('Name'), new TRequiredValidator);
        $login->addValidation('Login', new TRequiredValidator);
        $email->addValidation('Email', new TEmailValidator);

        if(SystemPreferenceService::isStrongPasswordEnabled())
        {
            $password->enableStrongPasswordValidation(_t('Password'));
            $repassword->enableStrongPasswordValidation(_t('Password confirmation'));
        }
        
        $row = $this->form->addFields( [new TLabel('ID', null, null, null, '100%'),$id],  [new TLabel(_t('Name'), null, null, null, '100%'),$name] );
        $row->layout = ['col-sm-6','col-sm-6'];
        $row = $this->form->addFields( [new TLabel(_t('Login'), null, null, null, '100%'),$login],  [new TLabel(_t('Email'), null, null, null, '100%'),$email] );
        $row->layout = ['col-sm-6','col-sm-6'];
        $row = $this->form->addFields( [new TLabel(_t('Main unit'), null, null, null, '100%'),$unit_id],  [new TLabel(_t('Front page'), null, null, null, '100%'),$frontpage_id] );
        $row->layout = ['col-sm-6','col-sm-6'];
        $row = $this->form->addFields( [new TLabel(_t('Password'), null, null, null, '100%'),$password],  [new TLabel(_t('Password confirmation'), null, null, null, '100%'),$repassword] );
        $row->layout = ['col-sm-6','col-sm-6'];

        $row = $this->form->addContent(['']);
        $row->layout = [' col-sm-12'];

        $this->form->addFields( [new TFormSeparator(_t('Units'))] );
        $this->form->addFields( [$units] );

        $row = $this->form->addContent(['']);
        $row->layout = [' col-sm-12'];

        $this->form->addFields( [new TFormSeparator(_t('Groups'))] );
        $this->form->addFields( [$groups] );
        
        $this->program_list = new TCheckList('program_list');
        $this->program_list->setIdColumn('id');
        $this->program_list->addColumn('id',    'ID',    'center',  '10%');
        $col_name    = $this->program_list->addColumn('name', _t('Name'),    'left',   '50%');
        $col_program = $this->program_list->addColumn('controller', _t('Menu path'),    'left',   '40%');
        $col_program->enableAutoHide(500);
        $this->program_list->setHeight(150);
        $this->program_list->makeScrollable();
        
        $col_name->enableSearch();
        $search_name = $col_name->getInputSearch();
        $search_name->placeholder = _t('Search');
        $search_name->style = 'width:50%;margin-left: 4px; border-radius: 4px';
        
        $col_program->setTransformer( function($value, $object, $row) {
            $menuparser = new TMenuParser('menu.xml');
            $paths = $menuparser->getPath($value);
            
            if ($paths)
            {
                return implode(' &raquo; ', $paths);
            }
        });
        
        $row = $this->form->addContent(['']);
        $row->layout = [' col-sm-12'];

        $this->form->addFields( [new TFormSeparator(_t('Programs'))] );
        $this->form->addFields( [$this->program_list] );
        
        TTransaction::open('permission');
        $this->program_list->addItems( SystemProgram::get() );
        TTransaction::close();
        
        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel(_t("Close"));
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);
        
        // add the container to the page
        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=SystemUserForm]');
        $style->width = '70% !important';   
        $style->show(true);
    }

    /**
     * Save user data
     */
    public function onSave($param)
    {
        try
        {
            // open a transaction with database 'permission'
            TTransaction::open('permission');
            
            $data = $this->form->getData();
            $this->form->setData($data);
            
            $this->form->validate();

            $object = new SystemUsers;
            $object->fromArray( (array) $data );
            
            unset($object->accepted_term_policy);

            $senha = $object->password;
            
            if( empty($object->login) )
            {
                throw new Exception(TAdiantiCoreTranslator::translate('The field ^1 is required', _t('Login')));
            }
            
            if( empty($object->id) )
            {
                if (SystemUsers::newFromLogin($object->login) instanceof SystemUsers)
                {
                    throw new Exception(_t('An user with this login is already registered'));
                }
                
                if (SystemUsers::newFromEmail($object->email) instanceof SystemUsers)
                {
                    throw new Exception(_t('An user with this e-mail is already registered'));
                }
                
                if ( empty($object->password) )
                {
                    throw new Exception(TAdiantiCoreTranslator::translate('The field ^1 is required', _t('Password')));
                }
                
                $object->active = 'Y';
            }
            
            if( $object->password )
            {
                if( $object->password !== $param['repassword'] )
                    throw new Exception(_t('The passwords do not match'));
                
                $object->password = password_hash($object->password, PASSWORD_BCRYPT);
            }
            else
            {
                unset($object->password);
            }
            
            $object->store();
            $object->clearParts();
            
            if( !empty($data->groups) )
            {
                foreach( $data->groups as $group_id )
                {
                    $object->addSystemUserGroup( new SystemGroup($group_id) );
                }
            }
            
            if( !empty($data->units) )
            {
                foreach( $param['units'] as $unit_id )
                {
                    $object->addSystemUserUnit( new SystemUnit($unit_id) );
                }
            }
            
            if (!empty($data->program_list))
            {
                foreach ($data->program_list as $program_id)
                {
                    $object->addSystemUserProgram( new SystemProgram( $program_id ) );
                }
            }
            
            $data = new stdClass;
            $data->id = $object->id;
            TForm::sendData('form_System_user', $data);
            
            // close the transaction
            TTransaction::close();
            
            // shows the success message
            new TMessage('info', TAdiantiCoreTranslator::translate('Record saved'), new TAction(['SystemUserList', 'onReload']));
            
            TScript::create("Template.closeRightPanel();");
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }
    
    /**
     * method onEdit()
     * Executed whenever the user clicks at the edit button da datagrid
     */
    function onEdit($param)
    {
        try
        {
            if (isset($param['key']))
            {
                // get the parameter $key
                $key=$param['key'];
                
                // open a transaction with database 'permission'
                TTransaction::open('permission');
                
                // instantiates object System_user
                $object = new SystemUsers($key);
                
                unset($object->password);
                
                $groups = array();
                $units  = array();
                
                if( $groups_db = $object->getSystemUserGroups() )
                {
                    foreach( $groups_db as $group )
                    {
                        $groups[] = $group->id;
                    }
                }
                
                if( $units_db = $object->getSystemUserUnits() )
                {
                    foreach( $units_db as $unit )
                    {
                        $units[] = $unit->id;
                    }
                }
                
                $program_ids = array();
                foreach ($object->getSystemUserPrograms() as $program)
                {
                    $program_ids[] = $program->id;
                }
                
                $object->program_list = $program_ids;
                $object->groups = $groups;
                $object->units  = $units;
                
                // fill the form with the active record data
                $this->form->setData($object);
                
                // close the transaction
                TTransaction::close();
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }
}
