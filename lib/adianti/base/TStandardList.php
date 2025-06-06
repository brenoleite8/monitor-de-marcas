<?php
namespace Adianti\Base;

use Adianti\Control\TPage;

/**
 * Standard page controller for listings
 *
 * This class serves as a standard controller for listing records within the Adianti Framework.
 * It provides a structured way to handle data presentation through forms, datagrids, and pagination.
 *
 * @version    7.5
 * @package    base
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class TStandardList extends TPage
{
    protected $form;
    protected $datagrid;
    protected $pageNavigation;
    
    use AdiantiStandardListTrait;
}
