<?php
namespace Adianti\Widget\Util;

use Adianti\Widget\Base\TElement;
use Adianti\Control\TAction;

/**
 * Represents a navigation pill bar for organizing content into multiple sections.
 * It allows users to navigate between sections in a visually structured manner.
 *
 * @version    7.5
 * @package    widget
 * @subpackage util
 * @author     Matheus Agnes Dias
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006-2014 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class TPillBar extends TElement
{
    protected $container;
    protected $items;
    protected $stepNumber = 1;
    
    /**
     * Class Constructor.
     * Initializes the navigation pill bar container and sets its default style.
     */
    public function __construct()
    {
        parent::__construct('div');
        $this->{'id'} = 'div_pills';
        $this->{'style'} = 'display:inline-block';
        
        $this->container = new TElement('ul');
        $this->container->{'class'} = 'nav nav-pills';
        
        parent::add( $this->container );
    }
    
    /**
     * Adds a new navigation item to the pill bar.
     *
     * @param string       $title  The title of the navigation item.
     * @param TAction|null $action An optional action associated with the item.
     */
    public function addItem($title, $action = null)
    {
        $li = new TElement('li');
        $li->{'class'} = 'nav-item';
        $this->items[ $title ] = $li;
        $this->container->add( $li );
        
        if ($action)
        {
            $span_title = new TElement('a');
            $span_title->{'href'}      = $action->serialize(true);
            $span_title->{'generator'} = 'adianti';
        }
        else
        {
            $span_title = new TElement('span');
        }
        
        $span_title->{'class'}     = 'nav-link btn-sm';
        $span_title->add( $title );
        
        $li->add( $span_title );
        
        $this->stepNumber ++;
    }
    
    /**
     * Selects a navigation item based on its index.
     *
     * @param int $index The index of the item to be selected.
     */
    public function selectIndex($index)
    {
        $n = 0;
        if ($this->items)
        {
            foreach ($this->items as $key => $item)
            {
               unset($item->{'class'});
               if ($n === $index)
               {
                   $item->{'class'} = 'active';
               }
               $n ++; 
            }
        }
    }
    
    /**
     * Selects a navigation item based on its title.
     *
     * @param string $title The title of the item to be marked as active.
     */
    public function select($title)
    {
        if ($this->items)
        {
            foreach ($this->items as $key => $item)
            {
                if ($key == $title)
                {
                    $item->{'class'} .= ' active';
                    $class = '';
                }
            }
        }
    }
}
