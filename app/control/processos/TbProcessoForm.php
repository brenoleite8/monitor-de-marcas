<?php

class TbProcessoForm extends TPage
{
    protected BootstrapFormBuilder $form;
    private $formFields = [];
    private static $database = 'db_monitor';
    private static $activeRecord = 'TbProcesso';
    private static $primaryKey = 'id';
    private static $formName = 'form_TbProcessoForm';

    use Adianti\Base\AdiantiFileSaveTrait;

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Cadastro de Processo");

        $this->form->enableCSRFProtection();

        $num_protocolo = new TEntry('num_protocolo');
        $system_unit_id = new THidden('system_unit_id');
        $data_ultimo_evento = new TDate('data_ultimo_evento');
        $id = new TEntry('id');
        $comprovante_file_name = new TFile('comprovante_file_name');

        $num_protocolo->addValidation("Num protocolo", new TRequiredValidator()); 

        $num_protocolo->setMaxLength(50);
        $system_unit_id->setValue(TSession::getValue('userunitid'));
        $data_ultimo_evento->setMask('dd/mm/yyyy');
        $data_ultimo_evento->setDatabaseMask('yyyy-mm-dd');
        $id->setEditable(false);
        $comprovante_file_name->enableFileHandling();
        $comprovante_file_name->setLimitUploadSize(5);
        $comprovante_file_name->enableDropZone("Arraste e solte seu arquivo aqui ou clique para selecionar!");
        $id->setSize('100%');
        $system_unit_id->setSize(200);
        $num_protocolo->setSize('100%');
        $data_ultimo_evento->setSize('100%');
        $comprovante_file_name->setSize('100%');

        $row1 = $this->form->addFields([new TLabel(new TImage('fas:asterisk #F44336')."Número do Protocolo", null, '12px', 'B', '100%'),$num_protocolo,$system_unit_id],[new TLabel("Data do Último Evento", null, '12px', 'B', '100%'),$data_ultimo_evento],[new TLabel("Id", null, '12px', 'B', '100%'),$id]);
        $row1->layout = [' col-sm-6 col-md-6',' col-sm-4 col-md-3',' col-sm-3 col-md-2'];

        $row2 = $this->form->addFields([new TLabel("Comprovante de Pagamento", null, '12px', 'B', '100%'),$comprovante_file_name]);
        $row2->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['TbProcessoList', 'onShow']), 'far:arrow-alt-circle-left #3F51B5');
        $this->btn_onshow = $btn_onshow;

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

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new TbProcesso(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            $this->saveBinaryFile($object, $data, 'comprovante_content', 'comprovante_file_name');
            $loadPageParam = [];

            if(!empty($param['target_container']))
            {
                $loadPageParam['target_container'] = $param['target_container'];
            }

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle');
            TApplication::loadPage('TbProcessoList', 'onShow', $loadPageParam); 

        }
        catch (Exception $e) // in case of exception
        {

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new TbProcesso($key); // instantiates the Active Record 

                $this->loadBinaryFile($object, 'comprovante_content', 'comprovante_file_name'); 

                $this->form->setData($object); // fill the form 

                TTransaction::close(); // close the transaction 
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

    }

    public function onShow($param = null)
    {

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}

