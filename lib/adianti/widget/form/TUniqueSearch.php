<?php
namespace Adianti\Widget\Form;

use Adianti\Widget\Form\TMultiSearch;
use Adianti\Widget\Form\AdiantiWidgetInterface;

/**
 * Unique Search Widget
 *
 * This widget extends TMultiSearch and ensures that only one item can be selected.
 *
 * @version    7.5
 * @package    widget
 * @subpackage form
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class TUniqueSearch extends TMultiSearch implements AdiantiWidgetInterface
{
    protected $size;
    
    /**
     * Class Constructor
     *
     * Initializes the unique search widget, ensuring that only one item can be selected.
     *
     * @param string $name The widget's name
     */
    public function __construct($name)
    {
        // executes the parent class constructor
        parent::__construct($name);
        parent::setMaxSize(1);
        parent::setDefaultOption(TRUE);
        parent::disableMultiple();
        
        $this->tag->{'widget'} = 'tuniquesearch';
    }
    
    /**
     * Set value
     *
     * Assigns a value to the widget. This method avoids using the parent setValue() 
     * to maintain compatibility.
     *
     * @param mixed $value The value to be set
     */
    public function setValue($value)
    {
        $this->value = $value; // avoid use parent::setValue() because compat mode
    }
    
    /**
     * Return the post data
     *
     * Retrieves the posted data for this widget.
     *
     * @return mixed The posted value or an empty string if not set
     */
    public function getPostData()
    {
        if (isset($_POST[$this->name]))
        {
            $val = $_POST[$this->name];
            return $val;
        }
        else
        {
            return '';
        }
    }
    
    /**
     * Returns the size
     *
     * Retrieves the size of the widget.
     *
     * @return mixed The size of the widget
     */
    public function getSize()
    {
        return $this->size;
    }
    
    /**
     * Show the component
     *
     * Renders the widget, setting its name attribute and calling the parent show() method.
     */
    public function show()
    {
        $this->tag->{'name'}  = $this->name; // tag name
        parent::show();
    }
}
