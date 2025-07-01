<?php

class TbProcesso extends TRecord
{
    const TABLENAME  = 'tb_processo';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const CREATED_BY_UNIT_ID  = 'system_unit_id';

    const CREATED_BY_USER_ID  = 'system_user_id_create';
    const UPDATED_BY_USER_ID  = 'system_user_id_update';

    const CREATEDAT  = 'created_at';
    const UPDATEDAT  = 'updated_at';

    private SystemUnit $system_unit;
    private SystemUsers $system_user_create;
    private SystemUsers $system_user_update;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('num_protocolo');
        parent::addAttribute('data_ultimo_evento');
        parent::addAttribute('comprovante_file_name');
        parent::addAttribute('comprovante_content');
        parent::addAttribute('system_unit_id');
        parent::addAttribute('system_user_id_create');
        parent::addAttribute('system_user_id_update');
        parent::addAttribute('created_at');
        parent::addAttribute('updated_at');
            
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
     * Method getTbProcessoEventos
     */
    public function getTbProcessoEventos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('tb_processo_id', '=', $this->id));
        return TbProcessoEvento::getObjects( $criteria );
    }

    public function set_tb_processo_evento_tb_processo_to_string($tb_processo_evento_tb_processo_to_string)
    {
        if(is_array($tb_processo_evento_tb_processo_to_string))
        {
            $values = TbProcesso::where('id', 'in', $tb_processo_evento_tb_processo_to_string)->getIndexedArray('id', 'id');
            $this->tb_processo_evento_tb_processo_to_string = implode(', ', $values);
        }
        else
        {
            $this->tb_processo_evento_tb_processo_to_string = $tb_processo_evento_tb_processo_to_string;
        }

        $this->vdata['tb_processo_evento_tb_processo_to_string'] = $this->tb_processo_evento_tb_processo_to_string;
    }

    public function get_tb_processo_evento_tb_processo_to_string()
    {
        if(!empty($this->tb_processo_evento_tb_processo_to_string))
        {
            return $this->tb_processo_evento_tb_processo_to_string;
        }
    
        $values = TbProcessoEvento::where('tb_processo_id', '=', $this->id)->getIndexedArray('tb_processo_id','{tb_processo->id}');
        return implode(', ', $values);
    }

    public function set_tb_processo_evento_system_unit_to_string($tb_processo_evento_system_unit_to_string)
    {
        if(is_array($tb_processo_evento_system_unit_to_string))
        {
            $values = SystemUnit::where('id', 'in', $tb_processo_evento_system_unit_to_string)->getIndexedArray('name', 'name');
            $this->tb_processo_evento_system_unit_to_string = implode(', ', $values);
        }
        else
        {
            $this->tb_processo_evento_system_unit_to_string = $tb_processo_evento_system_unit_to_string;
        }

        $this->vdata['tb_processo_evento_system_unit_to_string'] = $this->tb_processo_evento_system_unit_to_string;
    }

    public function get_tb_processo_evento_system_unit_to_string()
    {
        if(!empty($this->tb_processo_evento_system_unit_to_string))
        {
            return $this->tb_processo_evento_system_unit_to_string;
        }
    
        $values = TbProcessoEvento::where('tb_processo_id', '=', $this->id)->getIndexedArray('system_unit_id','{system_unit->name}');
        return implode(', ', $values);
    }

    /**
     * Method onBeforeDelete
     */
    public function onBeforeDelete()
    {
            

        if(TbProcessoEvento::where('tb_processo_id', '=', $this->id)->first())
        {
            throw new Exception("Não é possível deletar este registro pois ele está sendo utilizado em outra parte do sistema");
        }
    
    }

    
}

