<?php
    /**
    * VirtueMart Categories Module
    */

    // no direct access
    defined('_JEXEC') or die('Restricted access');

    if( !class_exists( 'VmConfig' ) ) require(JPATH_ADMINISTRATOR . '/components/com_virtuemart/helpers/config.php');
	
    $config= VmConfig::loadConfig();
    if( !class_exists( 'VirtueMartModelVendor' ) ) require(JPATH_VM_ADMINISTRATOR.'/models/vendor.php');
    if( !class_exists('TableMedias') ) require(JPATH_VM_ADMINISTRATOR.'/tables/medias.php');
    if( !class_exists('TableCategories') ) require(JPATH_VM_ADMINISTRATOR.'/tables/categories.php');
    if( !class_exists( 'VirtueMartModelCategory') ) require(JPATH_VM_ADMINISTRATOR.'/models/category.php');

    if( !class_exists( 'modSPVMSearchHelper') )
    {
        class modSPVMSearchHelper
        {
            public $categoryModel;
            private $tree;
            public function getTree()
            {
                return $this->tree;
            }

            public function generateTree($categories, $selectedId=0, $deep=0)
            {
                foreach ($categories as $category) {
                    $this->tree .= '<option '. (($category->virtuemart_category_id==$selectedId) ? 'selected="selected"':'') .' value="'.$category->virtuemart_category_id.'" data-name="'.$category->category_name.'">'. str_repeat('-', $deep*2) . ' ' . $category->category_name . '</option>';

                    $child =  $this->categoryModel->getChildCategoryList(1, $category->virtuemart_category_id);

                    if( is_array($child) and !empty($child) ){
                        $this->generateTree($child, $selectedId, $deep+1 );
                    }
                }
            }

            public function ajaxRequest($max_items, $module_id){

                if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
                {
                    if( JRequest::getInt('module_id')!=$module_id ) return;

                    $category_id = JRequest::getInt('category','0');
                    $productModel = VmModel::getModel('Product');
                    $products = $productModel->getProductListing (FALSE,  $max_items,  TRUE,  TRUE,  FALSE, TRUE, $category_id);
                    $document = JFactory::getDocument();

                    // Set the MIME type for JSON output.
                    $document->setMimeEncoding('application/json');
                    $results = array();
                    foreach($products as $product) $results[] = $product->product_name;

                    // Output the JSON data.
                    echo   json_encode($results);
                    die;
                }
            }
        }
}