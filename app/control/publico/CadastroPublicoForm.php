<?php

class CadastroPublicoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_CadastroPublicoForm';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param = null)
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Cadastro");

        $this->form->enableCSRFProtection();
        $this->style = 'clear:both';

        $nome = new TEntry('nome');
        $email = new TEntry('email');

        $nome->addValidation("Nome", new TRequiredValidator()); 
        $email->addValidation("E-mail", new TRequiredValidator()); 
        $email->addValidation("E-mail", new TEmailValidator(), []); 

        $nome->forceUpperCase();
        $email->forceLowerCase();
        $nome->setSize('100%');
        $email->setSize('100%');


        $row1 = $this->form->addFields([new TLabel(new TImage('fas:asterisk #F44336')."Nome Completo", null, '12px', 'B', '100%'),$nome]);
        $row1->layout = [' col-sm-12'];

        $row2 = $this->form->addFields([new TLabel(new TImage('fas:asterisk #F44336')."E-mail", null, '12px', 'B', '100%'),$email]);
        $row2->layout = [' col-sm-12'];

        // create the form actions
        $btn_onenviar = $this->form->addAction("ENVIAR", new TAction([$this, 'onEnviar']), 'fas:rocket #FFFFFF');
        $this->btn_onenviar = $btn_onenviar;
        $btn_onenviar->addStyleClass('btn-primary'); 

        $btn_onvoltar = $this->form->addHeaderAction("VOLTAR", new TAction([$this, 'onVoltar']), 'far:arrow-alt-circle-left #3F51B5');
        $this->btn_onvoltar = $btn_onvoltar;

        $container = new TElement('div');
        $container->style = 'margin:auto; margin-top:100px;max-width:460px;';
        $container->add($this->form);

        /*

        // create the form actions
        $btn_onenviar = $this->form->addAction("ENVIAR", new TAction([$this, 'onEnviar']), 'fas:rocket #FFFFFF');
        $this->btn_onenviar = $btn_onenviar;
        $btn_onenviar->addStyleClass('btn-primary'); 

        $btn_onvoltar = $this->form->addHeaderAction("VOLTAR", new TAction([$this, 'onVoltar']), 'far:arrow-alt-circle-left #3F51B5');
        $this->btn_onvoltar = $btn_onvoltar;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        }
        $container->add($this->form);

        */

        parent::add($container);

    }

    public function onEnviar($param = null) 
    {
        try 
        {
            $this->form->validate();

            $data = $this->form->getData();

            $msg = "Nome: {$param['nome']} - E-mail: {$param['email']}";
            $type = 'html';
            MailService::send('brenoleiteneto@gmail.com', 'Cadastro de Acesso', $msg, $type);

            $this->form->setData($data);

            TTransaction::open('permission');
            // VERIFICA SE JÁ TEM USUÁRIO CADASTRADO
            $countSystemUsers = SystemUsers::where('login', '=', trim($param['email']))->count();
            if($countSystemUsers > 0)
                throw new Exception('Usuário já cadastrado no sistema!');

            // ADICIONA UMA UNIDADE
            $newSystemUnit = new SystemUnit();
            $newSystemUnit->name = trim($param['nome']);
            $newSystemUnit->store();

            // ADICIONA UM USUÁRIO
            $senha = uniqid();
            $newSystemUsers                 = new SystemUsers();
            $newSystemUsers->name           = trim($param['nome']);
            $newSystemUsers->login          = trim($param['email']);
            $newSystemUsers->email          = trim($param['email']);
            $newSystemUsers->frontpage_id   = 10;
            $newSystemUsers->password       = md5($senha);
            $newSystemUsers->system_unit_id = $newSystemUnit->id;
            $newSystemUsers->active         = 'Y';
            $newSystemUsers->store();

            // VINCULA GRUPOS E UNIDADES AO USUÁRIO
            $newSystemUserUnit = new SystemUserUnit();
            $newSystemUserUnit->system_user_id = $newSystemUsers->id;
            $newSystemUserUnit->system_unit_id = $newSystemUnit->id;
            $newSystemUserUnit->store();

            $newSystemUserGroup = new SystemUserGroup();
            $newSystemUserGroup->system_user_id  = $newSystemUsers->id;
            $newSystemUserGroup->system_group_id = 2;
            $newSystemUserGroup->store();

            $aSystemGroupProgram = SystemGroupProgram::where('system_group_id', '=', 2)->load();
            if(!empty($aSystemGroupProgram)) {
                foreach ($aSystemGroupProgram as $oSystemGroupProgram) 
                {
                    $newSystemUserProgram = new SystemUserProgram();
                    $newSystemUserProgram->system_program_id = $oSystemGroupProgram->system_program_id;
                    $newSystemUserProgram->system_user_id    = $newSystemUsers->id;
                    $newSystemUserProgram->store();
                }
            }

            TTransaction::close();

            $msg = "Olá {$param['nome']}, <br> 
                    Bem vindo ao Monitor de Marcas! Segue os dados para acesso ao sistema: <br>
                    Login: {$param['email']} <br>
                    Senha: {$senha} <br>
                    Unidade: {$param['nome']} <br>
                    Agradecemos o acesso, qualquer dúvida envie um e-mail para: breno.leite@ufms.br";
            $type = 'html';
            MailService::send($param['email'], 'Acesso ao Monitor de Marcas', $msg, $type);

            new TMessage('info', 'Acesso cadastrado com sucesso!'.$senha);

        }
        catch (Exception $e) 
        {
            TTransaction::rollback();
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onVoltar($param = null) 
    {
        try 
        {
            TApplication::loadPage('LoginForm', 'onShow', []);

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onShow($param = null)
    {               

    } 

}

