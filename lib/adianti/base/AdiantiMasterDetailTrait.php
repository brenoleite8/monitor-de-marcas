<?php
namespace Adianti\Base;

use Adianti\Registry\TSession;
use Exception;

/**
 * Master Detail Trait
 *
 * Provides functionality for handling master-detail relationships within the Adianti Framework.
 *
 * @version    7.5
 * @package    base
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
trait AdiantiMasterDetailTrait
{
    /**
     * Stores items from the detail session into the database.
     *
     * @param string $model              The fully qualified class name of the detail model.
     * @param string $foreign_key        The foreign key column in the detail model that links to the master object.
     * @param object $master_object      The master object instance.
     * @param string $detail_id          The session key used to store detail items.
     * @param callable|null $transformer An optional transformation function applied to each detail object before storing.
     *
     * @return array An array of stored detail objects.
     * @throws Exception If an error occurs during the storage process.
     */
    public function storeItems($model, $foreign_key, $master_object, $detail_id, ?Callable $transformer = null)
    {
        $master_pkey    = $master_object->getPrimaryKey();
        $master_id      = $master_object->$master_pkey;
        $detail_objects = [];
        $detail_items   = TSession::getValue("{$detail_id}_items");
        
        if ($detail_items) 
        {
            $detail_ids = [];
            foreach ($detail_items as $key => $item)
            {
                foreach ($item as $item_key => $value)
                {
                    unset($item[$item_key]);
                    $item[str_replace("{$detail_id}_", '', $item_key)] = $value;
                }
                
                $detail_object = new $model;
                $detail_object->fromArray($item);
                $detail_pkey   = $detail_object->getPrimaryKey();
                
                if (is_int($key) || preg_match('/\w{8}-\w{4}-\w{4}-\w{4}-\w{12}/',$key))
                {
                    $detail_object->$detail_pkey = $key;
                }
                
                $detail_object->$foreign_key = $master_id;
                
                if ($transformer)
                {
                    call_user_func($transformer, $master_object, $detail_object);
                }
                
                $detail_object->__session__id = $key;
                $detail_object->store();
                $detail_objects[] = $detail_object;
                $detail_ids[] = $detail_object->$detail_pkey;
            }
            
            $repository = $model::where($foreign_key, '=', $master_id);
            if ($detail_ids)
            {
                $repository->where($detail_pkey, 'not in', $detail_ids);
            }
            $repository->delete(); 
        }
        else
        {
            $model::where($foreign_key, '=', $master_id)->delete();
        }
        
        return $detail_objects;
    }
    
    /**
     * Loads detail items from the database into the session.
     *
     * @param string $model              The fully qualified class name of the detail model.
     * @param string $foreign_key        The foreign key column in the detail model that links to the master object.
     * @param object $master_object      The master object instance.
     * @param string $detail_id          The session key used to store detail items.
     * @param callable|null $transformer An optional transformation function applied to each detail object before storing in the session.
     *
     * @return array An array of loaded detail objects.
     * @throws Exception If an error occurs while retrieving or processing the data.
     */
    public function loadItems($model, $foreign_key, $master_object, $detail_id, ?Callable $transformer = null)
    {
        $master_pkey  = $master_object->getPrimaryKey();
        $master_id    = $master_object->$master_pkey;
        $detail_items = [];
        $objects      = $model::where($foreign_key, '=', $master_id)->load();
        
        if ($objects)
        {
            foreach ($objects as $detail_object)
            {
                $detail_pkey  = $detail_object->getPrimaryKey();
                $array_object = $detail_object->toArray();
                
                $items = [];
                foreach ($array_object as $attribute => $value) 
                {
                    $items["{$detail_id}_{$attribute}"] = $value;
                }
                
                if ($transformer)
                {
                    $object_items = (object) $items;
                    call_user_func($transformer, $master_object, $detail_object, $object_items);
                    $items = (array) $object_items;
                }
                
                $detail_items[$detail_object->$detail_pkey] = $items;
            }    
        }
        
        TSession::setValue("{$detail_id}_items", $detail_items);
        
        return $objects;
    }
}
