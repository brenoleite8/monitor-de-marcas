<?php

class SystemUsers extends TRecord
{
    const TABLENAME  = 'system_users';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'max'; // {max, serial}

    private SystemUnit $system_unit;
    private SystemProgram $frontpage;

    private $unit;
    private $system_user_groups = array();
    private $system_user_programs = array();
    private $system_user_units = array();
            

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('name');
        parent::addAttribute('login');
        parent::addAttribute('password');
        parent::addAttribute('email');
        parent::addAttribute('frontpage_id');
        parent::addAttribute('system_unit_id');
        parent::addAttribute('active');
        parent::addAttribute('accepted_term_policy_at');
        parent::addAttribute('accepted_term_policy');
        parent::addAttribute('two_factor_enabled');
        parent::addAttribute('two_factor_type');
        parent::addAttribute('two_factor_secret');
    
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
     * Method set_system_program
     * Sample of usage: $var->system_program = $object;
     * @param $object Instance of SystemProgram
     */
    public function set_frontpage(SystemProgram $object)
    {
        $this->frontpage = $object;
        $this->frontpage_id = $object->id;
    }

    /**
     * Method get_frontpage
     * Sample of usage: $var->frontpage->attribute;
     * @returns SystemProgram instance
     */
    public function get_frontpage()
    {
    
        // loads the associated object
        if (empty($this->frontpage))
            $this->frontpage = new SystemProgram($this->frontpage_id);
    
        // returns the associated object
        return $this->frontpage;
    }

    /**
     * Method getTbMateriaisEstudos
     */
    public function getTbMateriaisEstudosBySystemUserCreates()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('system_user_id_create', '=', $this->id));
        return TbMateriaisEstudo::getObjects( $criteria );
    }
    /**
     * Method getTbMateriaisEstudos
     */
    public function getTbMateriaisEstudosBySystemUserUpdates()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('system_user_id_update', '=', $this->id));
        return TbMateriaisEstudo::getObjects( $criteria );
    }
    /**
     * Method getTbProcessos
     */
    public function getTbProcessosBySystemUserCreates()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('system_user_id_create', '=', $this->id));
        return TbProcesso::getObjects( $criteria );
    }
    /**
     * Method getTbProcessos
     */
    public function getTbProcessosBySystemUserUpdates()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('system_user_id_update', '=', $this->id));
        return TbProcesso::getObjects( $criteria );
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
    
        $values = TbMateriaisEstudo::where('system_user_id_update', '=', $this->id)->getIndexedArray('system_user_id_create','{system_user_create->name}');
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
    
        $values = TbMateriaisEstudo::where('system_user_id_update', '=', $this->id)->getIndexedArray('system_user_id_update','{system_user_update->name}');
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
    
        $values = TbMateriaisEstudo::where('system_user_id_update', '=', $this->id)->getIndexedArray('system_unit_id','{system_unit->name}');
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
    
        $values = TbProcesso::where('system_user_id_update', '=', $this->id)->getIndexedArray('system_unit_id','{system_unit->name}');
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
    
        $values = TbProcesso::where('system_user_id_update', '=', $this->id)->getIndexedArray('system_user_id_create','{system_user_create->name}');
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
    
        $values = TbProcesso::where('system_user_id_update', '=', $this->id)->getIndexedArray('system_user_id_update','{system_user_update->name}');
        return implode(', ', $values);
    }

    /**
     * Return the user' group's
     * @return Collection of SystemGroup
     */
    public function getSystemUserGroups()
    {
        return parent::loadAggregate('SystemGroup', 'SystemUserGroup', 'system_user_id', 'system_group_id', $this->id);
    }

    /**
     * Return the user' unit's
     * @return Collection of SystemUnit
     */
    public function getSystemUserUnits()
    {
        return parent::loadAggregate('SystemUnit', 'SystemUserUnit', 'system_user_id', 'system_unit_id', $this->id);
    }

    /**
     * Return the user' program's
     * @return Collection of SystemProgram
     */
    public function getSystemUserPrograms()
    {
        return parent::loadAggregate('SystemProgram', 'SystemUserProgram', 'system_user_id', 'system_program_id', $this->id);
    }

    /**
     * Returns the frontpage name
     */
    public function get_frontpage_name()
    {
        // loads the associated object
        if (empty($this->frontpage))
            $this->frontpage = new SystemProgram($this->frontpage_id);

        // returns the associated object
        return $this->frontpage->name;
    }

    /**
     * Returns the unit
     */
    public function get_unit()
    {
        // loads the associated object
        if (empty($this->unit))
            $this->unit = new SystemUnit($this->system_unit_id);

        // returns the associated object
        return $this->unit;
    }

    /**
     * Add a Group to the user
     * @param $object Instance of SystemGroup
     */
    public function addSystemUserGroup(SystemGroup $systemgroup)
    {
        $object = new SystemUserGroup;
        $object->system_group_id = $systemgroup->id;
        $object->system_user_id = $this->id;
        $object->store();
    }

    /**
     * Add a Unit to the user
     * @param $object Instance of SystemUnit
     */
    public function addSystemUserUnit(SystemUnit $systemunit)
    {
        $object = new SystemUserUnit;
        $object->system_unit_id = $systemunit->id;
        $object->system_user_id = $this->id;
        $object->store();
    }

    /**
     * Add a program to the user
     * @param $object Instance of SystemProgram
     */
    public function addSystemUserProgram(SystemProgram $systemprogram)
    {
        $object = new SystemUserProgram;
        $object->system_program_id = $systemprogram->id;
        $object->system_user_id = $this->id;
        $object->store();
    }

    /**
     * Get user group ids
     */
    public function getSystemUserGroupIds( $as_string = false )
    {
        $groupids = array();
        $groups = $this->getSystemUserGroups();
        if ($groups)
        {
            foreach ($groups as $group)
            {
                $groupids[] = $group->id;
            }
        }
    
        if ($as_string)
        {
            return implode(',', $groupids);
        }
    
        return $groupids;
    }

    /**
     * Get user unit ids
     */
    public function getSystemUserUnitIds( $as_string = false )
    {
        $unitids = array();
        $units = $this->getSystemUserUnits();
        if ($units)
        {
            foreach ($units as $unit)
            {
                $unitids[] = $unit->id;
            }
        }
    
        if ($as_string)
        {
            return implode(',', $unitids);
        }
    
        return $unitids;
    }

    /**
     * Get user group names
     */
    public function getSystemUserGroupNames()
    {
        $groupnames = array();
        $groups = $this->getSystemUserGroups();
        if ($groups)
        {
            foreach ($groups as $group)
            {
                $groupnames[] = $group->name;
            }
        }
    
        return implode(',', $groupnames);
    }

    /**
     * Reset aggregates
     */
    public function clearParts()
    {
        SystemUserGroup::where('system_user_id', '=', $this->id)->delete();
        SystemUserUnit::where('system_user_id', '=', $this->id)->delete();
        SystemUserProgram::where('system_user_id', '=', $this->id)->delete();
    }

    /**
     * Delete the object and its aggregates
     * @param $id object ID
     */
    public function delete($id = NULL)
    {
        // delete the related System_userSystem_user_group objects
        $id = isset($id) ? $id : $this->id;
    
        SystemUserGroup::where('system_user_id', '=', $id)->delete();
        SystemUserUnit::where('system_user_id', '=', $id)->delete();
        SystemUserProgram::where('system_user_id', '=', $id)->delete();
    
        // delete the object itself
        parent::delete($id);
    }

    /**
     * Validate user login
     * @param $login String with user login
     */
    public static function validate($login)
    {
        $user = self::newFromLogin($login);
    
        if ($user instanceof SystemUsers)
        {
            if ($user->active == 'N')
            {
                throw new Exception(_t('Inactive user'));
            }
        }
        else
        {
            throw new Exception(_t('User not found'));
        }
    
        return $user;
    }

    /**
     * Authenticate the user
     * @param $login String with user login
     * @param $password String with user password
     * @returns TRUE if the password matches, otherwise throw Exception
     */
    public static function authenticate($login, $password)
    {
        $user = self::newFromLogin($login);
        if (hash_equals($user->password, md5($password)))
        {
            self::updatePasswordHash($user, $password);
        }
        if (password_verify($password, $user->password)) 
        {
            if (password_needs_rehash($user->password, PASSWORD_DEFAULT))
            {
                self::updatePasswordHash($user, $password);
            }
        }
        else
        {
            throw new Exception(_t('Invalid username or password'));
        }
        return $user;
    }

    /**
     * Returns a SystemUser object based on its login
     * @param $login String with user login
     */
    static public function newFromLogin($login)
    {
        return SystemUsers::where('login', '=', $login)->first();
    }

    /**
     * Returns a SystemUser object based on its e-mail
     * @param $email String with user email
     */
    static public function newFromEmail($email)
    {
        return SystemUsers::where('email', '=', $email)->first();
    }

    /**
     * Return the programs the user has permission to run
     */
    public function getPrograms()
    {
        $programs = array();
    
        foreach( $this->getSystemUserGroups() as $group )
        {
            foreach( $group->getSystemPrograms() as $prog )
            {
                $programs[$prog->controller] = true;
            }
        }
            
        foreach( $this->getSystemUserPrograms() as $prog )
        {
            $programs[$prog->controller] = true;
        }
    
        return $programs;
    }

    /**
     * Return the programs the user has permission to run
     */
    public function getProgramsList()
    {
        $programs = array();
    
        foreach( $this->getSystemUserGroups() as $group )
        {
            foreach( $group->getSystemPrograms() as $prog )
            {
                $programs[$prog->controller] = $prog->name;
            }
        }
            
        foreach( $this->getSystemUserPrograms() as $prog )
        {
            $programs[$prog->controller] = $prog->name;
        }
    
        asort($programs);
        return $programs;
    }

    /**
     * Check if the user is within a group
     */
    public function checkInGroup( SystemGroup $group )
    {
        $user_groups = array();
        foreach( $this->getSystemUserGroups() as $user_group )
        {
            $user_groups[] = $user_group->id;
        }

        return in_array($group->id, $user_groups);
    }

    /**
     *
     */
    public static function getInGroups( $groups )
    {
        $collection = [];
        $users = self::all();
        if ($users)
        {
            foreach ($users as $user)
            {
                foreach ($groups as $group)
                {
                    if ($user->checkInGroup($group))
                    {
                        $collection[] = $user;
                    }
                }
            }
        }
        return $collection;
    }

    /**
     * Clone the entire object and related ones
     */
    public function cloneUser()
    {
        $groups   = $this->getSystemUserGroups();
        $units    = $this->getSystemUserUnits();
        $programs = $this->getSystemUserPrograms();
        unset($this->id);
        $this->name .= ' (clone)';
        $this->store();
        if ($groups)
        {
            foreach ($groups as $group)
            {
                $this->addSystemUserGroup( $group );
            }
        }
        if ($units)
        {
            foreach ($units as $unit)
            {
                $this->addSystemUserUnit( $unit );
            }
        }
        if ($programs)
        {
            foreach ($programs as $program)
            {
                $this->addSystemUserProgram( $program );
            }
        }
    }

            
    private static function updatePasswordHash($user, $userPassword)
    {
        $user->password = password_hash($userPassword, PASSWORD_DEFAULT);
        $user->store();
    }

     public function getProgramsActions()
    {
        $programs_actions = [];
        foreach( $this->getSystemUserGroups() as $group )
        {
            foreach( $group->getSystemPrograms() as $prog )
            {
                if($prog->actions)
                {
                    $programs_actions[$prog->controller] = [];
                    $actions = array_map(function($actions){
                        return $actions->action;
                    },json_decode($prog->actions));
                    $allowed_actions = json_decode($prog->allowed_actions);
                    $allowed_actions = array_flip($allowed_actions);
                    if($actions)
                    {
                        foreach($actions as $action)
                        {
                            if(!isset($programs_actions[$prog->controller][$action]))
                            {
                                $programs_actions[$prog->controller][$action] = false;
                            }
                            if(isset($allowed_actions[$action]))
                            {
                                $programs_actions[$prog->controller][$action] = true;
                            }
                        }   
                    }
                }
            }
        }
        return $programs_actions;
    }
}

