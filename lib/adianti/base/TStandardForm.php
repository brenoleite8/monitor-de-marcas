<?php
namespace Adianti\Base;

use Adianti\Control\TPage;

/**
 * Standard page controller for forms
 *
 * Standard page controller for forms.
 * This class extends TPage and is used as a base controller for handling forms.
 *
 * @version    7.5
 * @package    base
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class TStandardForm extends TPage
{
    protected $form;
    
    use AdiantiStandardFormTrait;
}
