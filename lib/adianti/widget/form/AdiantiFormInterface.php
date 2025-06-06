<?php
namespace Adianti\Widget\Form;

/**
 * Form Interface
 *
 * Interface for form components.
 * Defines a contract for handling form fields, data, and validation.
 *
 * @version    7.5
 * @package    widget
 * @subpackage form
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
interface AdiantiFormInterface
{
    public function setName($name);
    public function getName();
    public function addField(AdiantiWidgetInterface $field);
    public function delField(AdiantiWidgetInterface $field);
    public function setFields($fields);
    public function getField($name);
    public function getFields();
    public function clear();
    public function setData($object);
    public function getData($class = 'StdClass');
    public function validate();
    public function show();
}
