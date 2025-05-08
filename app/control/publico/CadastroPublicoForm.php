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
        $this->form->setFormTitle(" ");


        $google_forms = new TElement('iframe');


        $google_forms->width = '100%';
        $google_forms->height = '585px';
        $google_forms->src = "https://docs.google.com/forms/d/e/1FAIpQLSelo4Ci5BXeqU08jCDFzciq2Syn2csPufKipU-FOPKjIEzewQ/viewform?embedded=true";

        $this->google_forms = $google_forms;

        $row1 = $this->form->addFields([$google_forms]);
        $row1->layout = [' col-sm-12'];

        // create the form actions

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

        parent::add($container);

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

