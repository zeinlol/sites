<?php
/**
 * The optimizer model file
 *
 * @package 	customfilters
 * @author		Sakis Terz
 * @link		http://breakdesigns.net
 * @copyright	Copyright (c) 2012 - 2015 breakdesigns.net. All rights reserved.
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *				customfilters is free software. This version may have been modified
 *				pursuant to the GNU General Public License, and as distributed
 *				it includes or is derivative of works licensed under the GNU
 *				General Public License or other free or open source software
 *				licenses.
 * @version 	$Id: optimizer.php  2015-03-04 14:34:00Z sakis $
 * @since		1.9.5
 */

// No direct access.
defined('_JEXEC') or die;
// Load the model framework
jimport('joomla.application.component.modelform');

/**
 * the model class
 * @author	Sakis Terz
 * @since	1.0
 */
class CustomfiltersModelOptimizer extends JModelForm{
	/**
	 * @var string Model context string
	 */
	private $context = 'com_customfilters.optimizer';

	/**
	 * the indexes that should be added
	 */
	private $indexes=array(
		'#__virtuemart_category_categories'=>'category_parent_id',
		'#__virtuemart_calcs'=>'published',
		'#__virtuemart_product_prices'=>array('product_override_price ,override','product_price , override','virtuemart_shoppergroup_id , price_quantity_start ,product_price'),
		'#__virtuemart_products'=>array('published','published,product_parent_id'),
		'#__virtuemart_product_categories'=> 'virtuemart_category_id',
		'#__virtuemart_product_manufacturers'=>'virtuemart_manufacturer_id',			
		);

		public $oldIndexes=array();

		private $log=array('found'=>array(),'Notfound'=>array(),'added'=>array(), 'error'=>array());

		/**
		 * Method to get the record form located in models/forms
		 *
		 * 
		 * @author 		Sakis Terx
		 * @todo
		 * @see
		 * @access 		public
		 * @param 		array $data Data for the form.
		 * @param 		boolean $loadData True if the form is to load its own data (default case), false if not.
		 * @return 		mixed
		 * @since 		1.0
		 */
		public function getForm($data = array(), $loadData = true) {
			// Get the form.
			$form = $this->loadForm($this->context, $xml, array('control' => 'jform', 'load_data' => $loadData));
			if (empty($form)) {
				return false;
			}

			return $form;
		}

		
		/**
		 * Add dynamic indexes from the lang tables
		 * 
		 * @since	2.2.0
		 * @author 	Sakis Terz
		 */
		function setDynamicIndexes(){			
			$vmCompatibility=VmCompatibility::getInstance();
			$langs=VmConfig::get('active_languages',array());
			$db_langs=str_replace('-', '_', $langs);
			foreach ($db_langs as $lang){				
				$this->indexes['#__virtuemart_categories_'.$lang]='category_name';
				$this->indexes['#__virtuemart_manufacturers_'.$lang]='mf_name';
			}
			
			/*
			 *Custom value is a text without length in 2.9.9a and 2.9.9b. It is VarChar(18000) in 2.9.9c and higher
			 *Index cannot added in a field unless length is defined
			 */
			$vmVersion=VmConfig::getInstalledVersion();
			if(version_compare($vmVersion,'2.9.0','<') || version_compare($vmVersion,'3.0.0','>=')){
				$custom_value_field=$vmCompatibility->getColumnName('custom_value');
				$this->indexes['#__virtuemart_product_customfields']=$custom_value_field;
			}
		}
		
		/**
		 *
		 * Main function that runs the optimization queries for the database
		 * 
		 * @since 	1.9.5
		 * @author 	Sakis Terz
		 */
		public function optimize(){
			$this->setDynamicIndexes();
			$db=$this->getDbo();
			$indexes=array();
			$tables=array_keys($this->indexes);
			$indexNames=array();
			$existing_tables=array();

			//get the existing indexes
			foreach ($tables as $tbl){
				
				try{
					$query='SHOW INDEX FROM '.$tbl.' WHERE `Key_name`!="PRIMARY"';
					$db->setQuery($query);
					$db->query();
					$indexes[$tbl]=$db->loadObjectList();
					$existing_tables[]=$tbl;
				}
				//possibly the table does not exist or something goes wrong
				catch(Exception $e){
					unset($this->indexes[$tbl]);
				}				
			}
			$this->oldIndexes=$indexes;

			$this->checkAndIndex($this->indexes);
			
			if(count($this->log['Notfound'])>0 && count($this->log['added'])>0){
				$this->log['success']=(int)count($this->log['Notfound'])/count($this->log['added']);
			}else if(count($this->log['Notfound'])>0 && count($this->log['added'])==0)$this->log['success']=0;//nothing is done
			else $this->log['success']=-1;//nothing was done
			
			return ($this->log);
		}


		/**
		 * Checks the existing indexes
		 * Add when missing and update the log
		 *
		 * @param array $newIndexes
		 * @since 1.9.5
		 * @author Sakis Terz
		 */
		public function checkAndIndex($newIndexes){
			$db=$this->getDbo();
			$indexes=$this->oldIndexes;
			//check each index if it is set
			foreach ($newIndexes as $tbl_name=>$index){
				if(empty($index))continue;

				if(!is_array($index)){
					$newIndexName='cf_';
					$indexfields=explode(',',$index);
					$fieldCounter=count($indexfields);
					$found=-1;
					$foundcounter=0;
					$key_name='';
					foreach ($indexfields as $key=>$field){
						$field=trim($field);
						$newIndexName.=$field;
						if($key<$fieldCounter-1)$newIndexName.='_';
						//check if exist
						if($found!==false){
							foreach($indexes[$tbl_name] as $table_index){
								//found
								if($table_index->Column_name==$field && (int)$table_index->Seq_in_index==(int)$key+1){
									//check the sqquence in case of merged index
									$key_name =$table_index->Key_name;
									$foundcounter++;
									break;
								}//else $found=false;
							}
						}

					}
					if($foundcounter==$fieldCounter)$found=true;
					else $found=false;

					//echo $newIndexName,' :'.$index,'<br/>';

					if($found){
						//echo 'found:',$newIndexName,'<br/>';
						$this->log['found'][]=$tbl_name.':'.$newIndexName;
					}else{
						$this->log['Notfound'][]=$tbl_name.':'.$newIndexName;;
						//echo 'Nofound:',$newIndexName,'<br/>';

						$indexQuery='ALTER IGNORE TABLE '.$tbl_name.' ADD INDEX '.$db->quoteName($newIndexName).'('.$index.')';

						$db->setQuery($indexQuery);
						if($db->query()){
							if($db->getErrorMsg())$this->log['error'][]=$tbl_name.':'.$newIndexName;
							else $this->log['added'][]=$tbl_name.':'.$newIndexName;
						}else $this->log['error'][]=$tbl_name.':'.$newIndexName;
					}
				}
				//is array
				else{
					foreach ($index as $indx){
						$tmp_array[$tbl_name]=$indx;
						$this->checkAndIndex($tmp_array);
					}
				}
			}
		}

}
