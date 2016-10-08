<?php
/*------------------------------------------------------------------------
 # SM Super Categories - Version 1.0.0
 # Copyright (c) 2014 YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

class Sm_Supercategories_Model_System_Config_Source_OrderDirection
{
	public function toOptionArray()
	{
		return array(
			array('value'	=>	'ASC',		'label' => Mage::helper('supercategories')->__('Asc')),
			array('value'	=>	'DESC',		'label' => Mage::helper('supercategories')->__('Desc'))
		);
	}
}