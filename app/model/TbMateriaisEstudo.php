<?php

class TbMateriaisEstudo extends TRecord
{
    const TABLENAME  = 'tb_materiais_estudo';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const CREATED_BY_UNIT_ID  = 'system_unit_id';

    const CREATED_BY_USER_ID  = 'system_user_id_create';
    const UPDATED_BY_USER_ID  = 'system_user_id_update';

    const CREATEDAT  = 'created_at';
    const UPDATEDAT  = 'updated_at';

    private SystemUsers $system_user_create;
    private SystemUsers $system_user_update;
    private SystemUnit $system_unit;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('titulo');
        parent::addAttribute('palavras_chave');
        parent::addAttribute('link_video');
        parent::addAttribute('link_site');
        parent::addAttribute('imagem');
        parent::addAttribute('conteudo');
        parent::addAttribute('system_user_id_create');
        parent::addAttribute('system_user_id_update');
        parent::addAttribute('system_unit_id');
        parent::addAttribute('created_at');
        parent::addAttribute('updated_at');
    
    }

    /**
     * Method set_system_users
     * Sample of usage: $var->system_users = $object;
     * @param $object Instance of SystemUsers
     */
    public function set_system_user_create(SystemUsers $object)
    {
        $this->system_user_create = $object;
        $this->system_user_id_create = $object->id;
    }

    /**
     * Method get_system_user_create
     * Sample of usage: $var->system_user_create->attribute;
     * @returns SystemUsers instance
     */
    public function get_system_user_create()
    {
    
        // loads the associated object
        if (empty($this->system_user_create))
            $this->system_user_create = new SystemUsers($this->system_user_id_create);
    
        // returns the associated object
        return $this->system_user_create;
    }
    /**
     * Method set_system_users
     * Sample of usage: $var->system_users = $object;
     * @param $object Instance of SystemUsers
     */
    public function set_system_user_update(SystemUsers $object)
    {
        $this->system_user_update = $object;
        $this->system_user_id_update = $object->id;
    }

    /**
     * Method get_system_user_update
     * Sample of usage: $var->system_user_update->attribute;
     * @returns SystemUsers instance
     */
    public function get_system_user_update()
    {
    
        // loads the associated object
        if (empty($this->system_user_update))
            $this->system_user_update = new SystemUsers($this->system_user_id_update);
    
        // returns the associated object
        return $this->system_user_update;
    }
    /**
     * Method set_system_unit
     * Sample of usage: $var->system_unit = $object;
     * @param $object Instance of SystemUnit
     */
    public function set_system_unit(SystemUnit $object)
    {
        $this->system_unit = $object;
        $this->system_unit_id = $object->id;
    }

    /**
     * Method get_system_unit
     * Sample of usage: $var->system_unit->attribute;
     * @returns SystemUnit instance
     */
    public function get_system_unit()
    {
    
        // loads the associated object
        if (empty($this->system_unit))
            $this->system_unit = new SystemUnit($this->system_unit_id);
    
        // returns the associated object
        return $this->system_unit;
    }

    public function get_link_video_formatado()
    {
        if($this->link_video) {
            // Se não for um link embed
            if (strpos($this->link_video, 'embed') === false) {

                if (strpos($this->link_video, 'v=') !== false) {
                    parse_str(parse_url($this->link_video, PHP_URL_QUERY), $query_params);
                    return isset($query_params['v']) ? 'https://www.youtube.com/embed/'.$query_params['v'] : '';
                }           
            }
            return $this->link_video;
        }
        return '';
    }
        
}

