<?php

    /**
    * SP VirtueMart Category search module
    */

    // no direct access
    defined('_JEXEC') or die('Restricted access');

    require('helper.php');
    if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'config.php');

    VmConfig::loadConfig();

    /* Settings */
    $category_model = VmModel::getModel('Category');
    $category_id = $params->get('category_id', 0);
    $moduleclass_sfx = $params->get('moduleclass_sfx','');
    $max_search_suggest = $params->get('max_search_suggest','10');
    $load_jquery = $params->get('loadjquery','1');  // Load JQuery
    $load_typahead = $params->get('loadtypeahead','1');  // Load JQuery
    
    $module_id = $module->id;
    $active_category_id = JRequest::getInt('virtuemart_category_id', '0');
    $vendor_id = '1';
    $moduleName   = basename(dirname(__FILE__));
    $categories = $category_model->getChildCategoryList($vendor_id, $category_id);

    if(empty($categories)) return false;

    $modSPVMSearchHelper = new modSPVMSearchHelper();
    $modSPVMSearchHelper->categoryModel = $category_model;
    $modSPVMSearchHelper->generateTree($categories, $active_category_id, 0);


    $doc      = JFactory::getDocument();
    $cssFile  = JPATH_THEMES. '/'.$doc->template.'/css/'.$moduleName.'.css';


    if( $load_jquery=='1' ){
        $doc->addScript(JURI::base(true) . '/modules/'.$moduleName.'/assets/js/jquery-1.9.1.min.js');
    }
    
    if( $load_typahead=='1' ){
        $doc->addScript(JURI::base(true) . '/modules/'.$moduleName.'/assets/js/bootstrap-typeahead.js');
    }
    

    if(file_exists($cssFile)) {
        $doc->addStylesheet(JURI::base(true) . '/templates/'.$doc->template.'/css/'. $moduleName . '.css');
    } else {
        $doc->addStylesheet(JURI::base(true) . '/modules/'.$moduleName.'/assets/css/style.css');
    }

    $modSPVMSearchHelper->ajaxRequest($max_search_suggest, $module_id);
    require JModuleHelper::getLayoutPath($moduleName, $params->get('layout', 'default'));