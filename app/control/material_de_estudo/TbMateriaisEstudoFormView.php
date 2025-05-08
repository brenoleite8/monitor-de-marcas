<?php

class TbMateriaisEstudoFormView extends TPage
{
    protected $form; // form
    private static $database = 'db_monitor';
    private static $activeRecord = 'TbMateriaisEstudo';
    private static $primaryKey = 'id';
    private static $formName = 'formView_TbMateriaisEstudo';

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

        TTransaction::open(self::$database);
        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        $this->form->setTagName('div');

        $tb_materiais_estudo = new TbMateriaisEstudo($param['key']);
        // define the form title
        $this->form->setFormTitle(" ");

        $titulo     = $tb_materiais_estudo->titulo;
        $url        = $tb_materiais_estudo->link_site;
        $link_video = $tb_materiais_estudo->link_video_formatado;
        $this->form->setFormTitle($tb_materiais_estudo->titulo);

        $label3 = new TLabel("Palavras Chave: ", '', '12px', 'B');
        $text3 = new TTextDisplay($tb_materiais_estudo->palavras_chave, '', '12px', '');
        $iframe2 = new TElement('iframe');
        $image2 = new TImage($tb_materiais_estudo->imagem);
        $label5 = new TLabel("Acesse: ", '', '12px', 'B', '100%');
        $action2 = new TActionLink($tb_materiais_estudo->titulo, new TAction(['TbMateriaisEstudoFormView', 'openLink'], ['id'=> $tb_materiais_estudo->id]), '#2196F3', '12px', 'B', 'fas:external-link-alt #2196F3');
        $label2 = new TLabel("Conteúdo:", '', '12px', 'B', '100%');
        $text7 = new TTextDisplay($tb_materiais_estudo->conteudo, '', '12px', '');
        $label8 = new TLabel("Criado por:", '', '12px', 'B');
        $text8 = new TTextDisplay($tb_materiais_estudo->system_user_create->name, '', '12px', '');

        $image2->id = 'img';
        $image2->width = '100%';
        $iframe2->width = '100%';
        $image2->height = '500px';
        $iframe2->height = '400px';
        $iframe2->id = 'iframe_video';
        $iframe2->src = "{$link_video}";
        $action2->class = 'btn btn-default';

        $this->iframe2 = $iframe2;

        $row1 = $this->form->addFields([$label3,$text3]);
        $row1->layout = [' col-sm-12'];

        $row2 = $this->form->addFields([$iframe2]);
        $row2->layout = [' col-sm-12'];

        $row3 = $this->form->addFields([$image2]);
        $row3->layout = [' col-sm-12'];

        $row4 = $this->form->addFields([$label5,$action2]);
        $row4->layout = [' col-sm-12'];

        $row5 = $this->form->addFields([$label2,$text7]);
        $row5->layout = [' col-sm-12'];

        $row6 = $this->form->addFields([$label8,$text8]);
        $row6->layout = [' col-sm-12'];

        if(!$tb_materiais_estudo->link_video) {
            TScript::create("$('#formView_TbMateriaisEstudo #iframe_video').closest('.fb-field-container').hide();");
        }
        if(!$tb_materiais_estudo->link_site) {
            TScript::create("$('#formView_TbMateriaisEstudo .fa-external-link-alt').closest('.fb-field-container').hide();");
        }
        if(!$tb_materiais_estudo->link_site) {
            TScript::create("$('#formView_TbMateriaisEstudo #img').closest('.fb-field-container').hide();");
        }

        $btnTbMateriaisEstudoListOnShowAction = new TAction(['TbMateriaisEstudoList', 'onShow']);
        $btnTbMateriaisEstudoListOnShowLabel = new TLabel("VOLTAR");

        $btnTbMateriaisEstudoListOnShow = $this->form->addHeaderAction($btnTbMateriaisEstudoListOnShowLabel, $btnTbMateriaisEstudoListOnShowAction, 'far:arrow-alt-circle-left #3F51B5'); 
        $btnTbMateriaisEstudoListOnShowLabel->setFontSize('12px'); 
        $btnTbMateriaisEstudoListOnShowLabel->setFontColor('#333'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        }
        $container->add($this->form);

        TTransaction::close();
        parent::add($container);

    }

    public function onShow($param = null)
    {     

    }

    public static function openLink($param = null) 
    {
        try 
        {
            TTransaction::openFake('db_monitor');
            $oTbMaterialEstudo = new TbMateriaisEstudo($param['id']);
            TTransaction::close();

            TScript::create("window.open('".$oTbMaterialEstudo->link_site."', '_blank');");

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

}

