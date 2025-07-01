<?php

class TbMateriaisEstudoForm extends TPage
{
    protected BootstrapFormBuilder $form;
    private $formFields = [];
    private static $database = 'db_monitor';
    private static $activeRecord = 'TbMateriaisEstudo';
    private static $primaryKey = 'id';
    private static $formName = 'form_TbMateriaisEstudoForm';

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
        $this->form->setFormTitle("Cadastro de Material de Estudo");

        $this->form->enableCSRFProtection();

        $titulo = new TEntry('titulo');
        $id = new THidden('id');
        $bhelper_68161dfea2e2c = new BHelper();
        $palavras_chave = new TEntry('palavras_chave');
        $link_video = new TEntry('link_video');
        $link_site = new TEntry('link_site');
        $imagem = new TFile('imagem');
        $conteudo = new THtmlEditor('conteudo');

        $titulo->addValidation("Titulo", new TRequiredValidator()); 
        $palavras_chave->addValidation("Palavras chave", new TRequiredValidator()); 
        $conteudo->addValidation("Conteudo", new TRequiredValidator()); 

        $bhelper_68161dfea2e2c->enableHover();
        $bhelper_68161dfea2e2c->setSide("auto");
        $bhelper_68161dfea2e2c->setIcon(new TImage("fas:info-circle #2196F3"));
        $bhelper_68161dfea2e2c->setTitle("Info");
        $bhelper_68161dfea2e2c->setContent("Separar as palavras chaves por <b>, (Vírgula)</b>.");
        $imagem->enableFileHandling();
        $imagem->setLimitUploadSize(2);
        $imagem->setAllowedExtensions(["png","jpeg","jpg"]);
        $imagem->enableImageGallery('50', 50);
        $imagem->enableDropZone("Arraste e solte seu arquivo aqui ou clique para selecionar!");
        $id->setSize(200);
        $titulo->setSize('100%');
        $imagem->setSize('100%');
        $link_site->setSize('100%');
        $link_video->setSize('100%');
        $conteudo->setSize('100%', 440);
        $palavras_chave->setSize('100%');
        $bhelper_68161dfea2e2c->setSize('16');

        $row1 = $this->form->addFields([new TLabel(new TImage('fas:asterisk #F44336')."Título", null, '12px', 'B', '100%'),$titulo,$id]);
        $row1->layout = [' col-sm-12'];

        $row2 = $this->form->addFields([new TLabel(new TImage('fas:asterisk #F44336')."Palavras Chave", null, '12px', 'B'),$bhelper_68161dfea2e2c,$palavras_chave]);
        $row2->layout = [' col-sm-12'];

        $row3 = $this->form->addContent([new TFormSeparator("", '#333', '18', '#eee')]);
        $row4 = $this->form->addContent([new TFormSeparator("<b>Conteúdos</b>", '#3F51B5', '14', '#eee')]);
        $row5 = $this->form->addFields([new TLabel("Link YouTube", null, '12px', 'B', '100%'),$link_video]);
        $row5->layout = [' col-sm-12'];

        $row6 = $this->form->addFields([new TLabel("Link Site", null, '12px', 'B', '100%'),$link_site]);
        $row6->layout = [' col-sm-12'];

        $row7 = $this->form->addFields([new TLabel("Imagem", null, '12px', 'B', '100%'),$imagem]);
        $row7->layout = [' col-sm-12'];

        $row8 = $this->form->addFields([new TLabel(new TImage('fas:asterisk #F44336')."Conteúdo/Observações", null, '12px', 'B', '100%'),$conteudo]);
        $row8->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onshow = $this->form->addAction("Voltar ", new TAction(['TbMateriaisEstudoList', 'onShow']), 'far:arrow-alt-circle-left #3F51B5');
        $this->btn_onshow = $btn_onshow;

        $btn_onshow = $this->form->addHeaderAction("Voltar", new TAction(['TbMateriaisEstudoList', 'onShow']), 'far:arrow-alt-circle-left #3F51B5');
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

            $object = new TbMateriaisEstudo(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            if(!empty($object->link_video))
                $object->link_video = self::embedYoutube($object->link_video);

            $imagem_dir = 'app/images';  

            $object->store(); // save the object 

            $this->saveFile($object, $data, 'imagem', $imagem_dir);
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
            TApplication::loadPage('TbMateriaisEstudoList', 'onShow', $loadPageParam); 

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

                $object = new TbMateriaisEstudo($key); // instantiates the Active Record 

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

    public static function embedYoutube($param = null) 
    {
        try 
        {
            // Expressão regular para extrair o ID do vídeo
            $pattern = '/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/';

            if (preg_match($pattern, $param, $matches)) {
                $videoId = $matches[1];
                return "https://www.youtube.com/embed/" . $videoId;
            } else {
                throw new Exception('Link do YouTube Inválido!');
            }
        }
        catch (Exception $e) 
        {
            throw $e;
        }
    }

}

