<?php
namespace Adianti\Base;

use Adianti\Control\TPage;

/**
 * Standard page controller for form/listings
 *
 * This class provides a standard implementation for a form-based listing page, 
 * combining form handling and a data grid for presenting results.
 *
 * @version    7.5
 * @package    base
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class TStandardFormList extends TPage
{
    protected $form;
    protected $datagrid;
    protected $pageNavigation;
    protected $filterField;
    protected $loaded;
    protected $limit;
    protected $order;
    protected $direction;
    protected $criteria;
    protected $transformCallback;
    
    use AdiantiStandardFormListTrait;
}
