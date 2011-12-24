<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Winans Creative 2009, Intelligent Spark 2010, iserv.ch GmbH 2010
 * @author     Fred Bliss <fred.bliss@intelligentspark.com>
 * @author     Andreas Schempp <andreas@schempp.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */
 
 
/**
 * Palettes
 */

$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__']['showItem'] = 'showItem';
$GLOBALS['TL_DCA']['tl_module']['palettes']['catalog_breadcrumb'] = '{title_legend},name,headline,type;{config_legend},catalog;{nav_legend},includeRoot,showHidden,showItem,categoryField;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['showItem'] = 'nameField';

/**
 * Fields
 */
 
$GLOBALS['TL_DCA']['tl_module']['fields']['showItem'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['showItem'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'w50 clr')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['nameField'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['nameField'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'		  => array('tl_module_catalog', 'getCatalogTextFields'),
	'eval'                    => array('maxlength'=>255, 'mandatory'=>true, 'tl_class'=>'w50')
);


$GLOBALS['TL_DCA']['tl_module']['fields']['categoryField'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['categoryField'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'		  => array('tl_module_catalog_breadcrumb', 'getCatalogCategoryFields'),
	'eval'                    => array('maxlength'=>255, 'mandatory'=>true, 'tl_class'=>'w50')
);


class tl_module_catalog_breadcrumb extends Backend
{
	
	/**
	 * Get all catalog fields and return them as array
	 * @return array
	 */
	public function getCatalogCategoryFields(DataContainer $dc)
	{
		
		$objFields = $this->Database->prepare("SELECT c.* FROM tl_catalog_fields c, tl_module m WHERE c.pid=m.catalog AND m.id=? AND c.type IN ('tags','select') AND c.itemTable='tl_page' ORDER BY c.sorting ASC")
							->execute($dc->id);

		while ($objFields->next())
		{
			$value = strlen($objFields->name) ? $objFields->name.' ' : '';
			$value .= '['.$objFields->colName.':'.$objFields->type.']';
			$fields[$objFields->colName] = $value;
		}

		return $fields;

	}


}


?>
