<?php

class TbProcessoEvento extends TRecord
{
    const TABLENAME  = 'tb_processo_evento';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const CREATED_BY_UNIT_ID  = 'system_unit_id';

    const CREATEDAT  = 'created_at';
    const UPDATEDAT  = 'updated_at';

    private SystemUnit $system_unit;
    private TbProcesso $tb_processo;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('tb_processo_id');
        parent::addAttribute('num_revista');
        parent::addAttribute('data_evento');
        parent::addAttribute('texto_evento');
        parent::addAttribute('notificado_sn');
        parent::addAttribute('system_unit_id');
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
     * Method set_tb_processo
     * Sample of usage: $var->tb_processo = $object;
     * @param $object Instance of TbProcesso
     */
    public function set_tb_processo(TbProcesso $object)
    {
        $this->tb_processo = $object;
        $this->tb_processo_id = $object->id;
    }

    /**
     * Method get_tb_processo
     * Sample of usage: $var->tb_processo->attribute;
     * @returns TbProcesso instance
     */
    public function get_tb_processo()
    {
    
        // loads the associated object
        if (empty($this->tb_processo))
            $this->tb_processo = new TbProcesso($this->tb_processo_id);
    
        // returns the associated object
        return $this->tb_processo;
    }

    
}

