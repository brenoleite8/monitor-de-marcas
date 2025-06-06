<?php
namespace Adianti\Widget\Wrapper;

use Adianti\Widget\Form\TSelect;
use Adianti\Database\TCriteria;

use Exception;

/**
 * Database Select Widget
 *
 * This widget extends TSelect and allows the selection of values retrieved from a database table.
 *
 * @version    7.5
 * @package    widget
 * @subpackage wrapper
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class TDBSelect extends TSelect
{
    protected $items; // array containing the combobox options
    
    use AdiantiDatabaseWidgetTrait;
    
    /**
     * Class Constructor
     *
     * Initializes the database-driven select widget.
     *
     * @param string     $name        Widget's name
     * @param string     $database    Database connection name
     * @param string     $model       Model class name
     * @param string     $key         Table field to be used as the key in the select options
     * @param string     $value       Table field to be displayed in the select options
     * @param string|null $ordercolumn Column name to order the values (optional)
     * @param TCriteria|null $criteria Criteria object to filter the model records (optional)
     *
     * @throws Exception If any error occurs during instantiation
     */
    public function __construct($name, $database, $model, $key, $value, $ordercolumn = NULL, ?TCriteria $criteria = NULL)
    {
        // executes the parent class constructor
        parent::__construct($name);
        
        // load items
        parent::addItems( self::getItemsFromModel($database, $model, $key, $value, $ordercolumn, $criteria) );
    }
}
