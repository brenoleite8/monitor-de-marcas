<?php

class SystemUnit extends TRecord
{
    const TABLENAME  = 'system_unit';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('name');
        parent::addAttribute('connection_name');
            
    }

    /**
     * Method getTbMateriaisEstudos
     */
    public function getTbMateriaisEstudos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('system_unit_id', '=', $this->id));
        return TbMateriaisEstudo::getObjects( $criteria );
    }
    /**
     * Method getTbProcessos
     */
    public function getTbProcessos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('system_unit_id', '=', $this->id));
        return TbProcesso::getObjects( $criteria );
    }
    /**
     * Method getTbProcessoEventos
     */
    public function getTbProcessoEventos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('system_unit_id', '=', $this->id));
        return TbProcessoEvento::getObjects( $criteria );
    }

    public function set_tb_materiais_estudo_system_user_create_to_string($tb_materiais_estudo_system_user_create_to_string)
    {
        if(is_array($tb_materiais_estudo_system_user_create_to_string))
        {
            $values = SystemUsers::where('id', 'in', $tb_materiais_estudo_system_user_create_to_string)->getIndexedArray('name', 'name');
            $this->tb_materiais_estudo_system_user_create_to_string = implode(', ', $values);
        }
        else
        {
            $this->tb_materiais_estudo_system_user_create_to_string = $tb_materiais_estudo_system_user_create_to_string;
        }

        $this->vdata['tb_materiais_estudo_system_user_create_to_string'] = $this->tb_materiais_estudo_system_user_create_to_string;
    }

    public function get_tb_materiais_estudo_system_user_create_to_string()
    {
        if(!empty($this->tb_materiais_estudo_system_user_create_to_string))
        {
            return $this->tb_materiais_estudo_system_user_create_to_string;
        }
    
        $values = TbMateriaisEstudo::where('system_unit_id', '=', $this->id)->getIndexedArray('system_user_id_create','{system_user_create->name}');
        return implode(', ', $values);
    }

    public function set_tb_materiais_estudo_system_user_update_to_string($tb_materiais_estudo_system_user_update_to_string)
    {
        if(is_array($tb_materiais_estudo_system_user_update_to_string))
        {
            $values = SystemUsers::where('id', 'in', $tb_materiais_estudo_system_user_update_to_string)->getIndexedArray('name', 'name');
            $this->tb_materiais_estudo_system_user_update_to_string = implode(', ', $values);
        }
        else
        {
            $this->tb_materiais_estudo_system_user_update_to_string = $tb_materiais_estudo_system_user_update_to_string;
        }

        $this->vdata['tb_materiais_estudo_system_user_update_to_string'] = $this->tb_materiais_estudo_system_user_update_to_string;
    }

    public function get_tb_materiais_estudo_system_user_update_to_string()
    {
        if(!empty($this->tb_materiais_estudo_system_user_update_to_string))
        {
            return $this->tb_materiais_estudo_system_user_update_to_string;
        }
    
        $values = TbMateriaisEstudo::where('system_unit_id', '=', $this->id)->getIndexedArray('system_user_id_update','{system_user_update->name}');
        return implode(', ', $values);
    }

    public function set_tb_materiais_estudo_system_unit_to_string($tb_materiais_estudo_system_unit_to_string)
    {
        if(is_array($tb_materiais_estudo_system_unit_to_string))
        {
            $values = SystemUnit::where('id', 'in', $tb_materiais_estudo_system_unit_to_string)->getIndexedArray('name', 'name');
            $this->tb_materiais_estudo_system_unit_to_string = implode(', ', $values);
        }
        else
        {
            $this->tb_materiais_estudo_system_unit_to_string = $tb_materiais_estudo_system_unit_to_string;
        }

        $this->vdata['tb_materiais_estudo_system_unit_to_string'] = $this->tb_materiais_estudo_system_unit_to_string;
    }

    public function get_tb_materiais_estudo_system_unit_to_string()
    {
        if(!empty($this->tb_materiais_estudo_system_unit_to_string))
        {
            return $this->tb_materiais_estudo_system_unit_to_string;
        }
    
        $values = TbMateriaisEstudo::where('system_unit_id', '=', $this->id)->getIndexedArray('system_unit_id','{system_unit->name}');
        return implode(', ', $values);
    }

    public function set_tb_processo_system_unit_to_string($tb_processo_system_unit_to_string)
    {
        if(is_array($tb_processo_system_unit_to_string))
        {
            $values = SystemUnit::where('id', 'in', $tb_processo_system_unit_to_string)->getIndexedArray('name', 'name');
            $this->tb_processo_system_unit_to_string = implode(', ', $values);
        }
        else
        {
            $this->tb_processo_system_unit_to_string = $tb_processo_system_unit_to_string;
        }

        $this->vdata['tb_processo_system_unit_to_string'] = $this->tb_processo_system_unit_to_string;
    }

    public function get_tb_processo_system_unit_to_string()
    {
        if(!empty($this->tb_processo_system_unit_to_string))
        {
            return $this->tb_processo_system_unit_to_string;
        }
    
        $values = TbProcesso::where('system_unit_id', '=', $this->id)->getIndexedArray('system_unit_id','{system_unit->name}');
        return implode(', ', $values);
    }

    public function set_tb_processo_system_user_create_to_string($tb_processo_system_user_create_to_string)
    {
        if(is_array($tb_processo_system_user_create_to_string))
        {
            $values = SystemUsers::where('id', 'in', $tb_processo_system_user_create_to_string)->getIndexedArray('name', 'name');
            $this->tb_processo_system_user_create_to_string = implode(', ', $values);
        }
        else
        {
            $this->tb_processo_system_user_create_to_string = $tb_processo_system_user_create_to_string;
        }

        $this->vdata['tb_processo_system_user_create_to_string'] = $this->tb_processo_system_user_create_to_string;
    }

    public function get_tb_processo_system_user_create_to_string()
    {
        if(!empty($this->tb_processo_system_user_create_to_string))
        {
            return $this->tb_processo_system_user_create_to_string;
        }
    
        $values = TbProcesso::where('system_unit_id', '=', $this->id)->getIndexedArray('system_user_id_create','{system_user_create->name}');
        return implode(', ', $values);
    }

    public function set_tb_processo_system_user_update_to_string($tb_processo_system_user_update_to_string)
    {
        if(is_array($tb_processo_system_user_update_to_string))
        {
            $values = SystemUsers::where('id', 'in', $tb_processo_system_user_update_to_string)->getIndexedArray('name', 'name');
            $this->tb_processo_system_user_update_to_string = implode(', ', $values);
        }
        else
        {
            $this->tb_processo_system_user_update_to_string = $tb_processo_system_user_update_to_string;
        }

        $this->vdata['tb_processo_system_user_update_to_string'] = $this->tb_processo_system_user_update_to_string;
    }

    public function get_tb_processo_system_user_update_to_string()
    {
        if(!empty($this->tb_processo_system_user_update_to_string))
        {
            return $this->tb_processo_system_user_update_to_string;
        }
    
        $values = TbProcesso::where('system_unit_id', '=', $this->id)->getIndexedArray('system_user_id_update','{system_user_update->name}');
        return implode(', ', $values);
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
    
        $values = TbProcessoEvento::where('system_unit_id', '=', $this->id)->getIndexedArray('tb_processo_id','{tb_processo->id}');
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
    
        $values = TbProcessoEvento::where('system_unit_id', '=', $this->id)->getIndexedArray('system_unit_id','{system_unit->name}');
        return implode(', ', $values);
    }

    
}

