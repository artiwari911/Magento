<?php
/*------------------------------------------------------------------------
 # SM maxshop - Version 1.0
 # Copyright (c) 2014 The YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.magentech.com
-------------------------------------------------------------------------*/
//die('aaa');
class Sm_Maxshop_Model_Observer {

	public function less_compile( $observer ){	
	
		$setting = Mage::helper('maxshop/data');
		$storeCode = Mage::app()->getStore()->getCode();
		$less_theme_compile     = Mage::getStoreConfig('maxshop_cfg/advanced/less_compile');
		$preset_name 			= Mage::getStoreConfig('maxshop_cfg/general/color');
		$device_responsive      = Mage::getStoreConfig('maxshop_cfg/general/device_responsive'); 
		$direction      		= Mage::getStoreConfig('maxshop_cfg/general/direction');
		
		if ( !Mage::app()->getStore()->isAdmin() && $less_theme_compile ){
			if (!class_exists('Less_Parser')) {			
				include_once(Mage::getBaseDir('lib').'Less/Version.php');
				include_once(Mage::getBaseDir('lib').'Less/Parser.php');
			}

			if ( class_exists('Less_Parser') && $less_theme_compile ){
				$skin_base_dir = Mage::getDesign()->getSkinBaseDir();
				$skin_base_url = Mage::getDesign()->getSkinUrl();

				define('LESS_PATH', $skin_base_dir.'/less');
				define('CSS__PATH', $skin_base_dir.'/css');						
				
				$import_dirs = array(
						LESS_PATH.'/path/' => $skin_base_url.'/less/path/',
						LESS_PATH.'/bootstrap/' => $skin_base_url.'/less/bootstrap/'
				);
				$options = array( 'compress'=>true );
				
				if ( file_exists(LESS_PATH.'/theme.less') && $less_theme_compile  ){
				
					if ( $storeCode ){
						$output_cssf = CSS__PATH.'/theme-'.$storeCode.'.css';
					} else {
						$output_cssf = CSS__PATH.'/theme-default.css';
					}
					
					$less = new Less_Parser($options);
					$less->SetImportDirs( $import_dirs );
					$less->parseFile(LESS_PATH.'/theme.less', $skin_base_url.'css/');
					
					if ( file_exists(LESS_PATH.'/theme-'.$preset_name.'.less') ){
						$less->parseFile(LESS_PATH.'/theme-'.$preset_name.'.less', $skin_base_url.'css/');
					}

					if( $device_responsive == 1 ){
						$less->parseFile(LESS_PATH.'/path/yt-responsive.less', $skin_base_url.'css/');
					} else {
						$less->parseFile(LESS_PATH.'/path/yt-non-responsive.less', $skin_base_url.'css/');
					}

					if( $direction == 2 ){
						$less->parseFile(LESS_PATH.'/path/theme-rtl.less', $skin_base_url.'css/');
						$less->parseFile(LESS_PATH.'/path/header-style-rtl.less', $skin_base_url.'css/');
						$less->parseFile(LESS_PATH.'/path/yt-responsive-header-rtl.less', $skin_base_url.'css/');
						if( $device_responsive == 1 ){
						$less->parseFile(LESS_PATH.'/path/yt-responsive-rtl.less', $skin_base_url.'css/');
						} else {
							$less->parseFile(LESS_PATH.'/path/yt-non-responsive-rtl.less', $skin_base_url.'css/');
						}
					}
					
					$cache = $less->getCss();
					file_put_contents($output_cssf, $cache);
					
				}
			
			}
		}
		
	}			
	
}