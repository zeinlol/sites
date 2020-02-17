<?php
/*------------------------------------------------------------------------
# Virtuemart Product Compare - Virtuemart Product Compare For Virtuemart Component 
# ------------------------------------------------------------------------
# author    WebKul software private limited 
# copyright Copyright (C) 2010 webkul.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://webkul.com
# Technical Support:  Forum - http://webkul.com/index.php?Itemid=86&option=com_kunena
-------------------------------------------------------------------------*/
// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );
$unique_id = $_GET['unique_id'];
$session =& JFactory::getSession();	

$document = JFactory::getDocument();
//$document->addScript('https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js');
$document->addStyleSheet(JURI::root().'components/com_virtuemartproductcompare/css/compare.css');

if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'config.php');
VmConfig::loadConfig();
require_once('helper.php');
$productModel = VmModel::getModel('Product');

vmJsApi::cssSite(); // for popup	
	vmJsApi::jPrice(); // for popup


				    $session_product=$session->get($unique_id);
				$plugin = JPluginHelper::getPlugin('system', 'vmproductcompare');
				  
					$params = new JRegistry($plugin->params);
					$country=$params->get('country');	

					$show_product_name=$params->get('show_product_name');
					$show_product_image=$params->get('show_product_image');
					$show_product_rating=$params->get('show_product_rating');
					$show_product_price=$params->get('show_product_price');
					$show_product_description=$params->get('show_product_description');
					$show_product_manufacture=$params->get('show_product_manufacture');
					$show_product_availability=$params->get('show_product_availability');
					$show_product_sku=$params->get('show_product_sku');
					$show_product_weight=$params->get('show_product_weight');
					$show_product_addtocart=$params->get('show_product_addtocart');
					$show_product_action=$params->get('show_product_action');	

  if($session_product){
 
				    $arr = array($session_product);			    
				    $counter=0;
				    foreach($session_product->productid as $result)
				    {
				    
				    if($result)
				      {
				    
				      $counter++;
				      }
				    }
				    $counter;	

				    $db =& JFactory::getDBO();
				    $query='SELECT vc.currency_symbol,vc.currency_positive_style FROM #__virtuemart_currencies AS vc
				    LEFT JOIN #__virtuemart_vendors AS vv ON vv.vendor_currency = vc.virtuemart_currency_id 	
				    Where vv.virtuemart_vendor_id=1';
				    $db->setQuery($query);	
				    $wk_currency = $db->loadAssoclist();				
				
	if($counter>0)
	{
					
	$width=80/$counter;
	}
}
?>
<style>
.product-details {
width: <?php echo $width; ?>%;
}
</style>


<h1 class='header'><span class="pull-left"><?php echo JText::_('COMPARE_PRODUCTS'); ?> </span>
</h1>
<div class='shop_home pull-right'><a href='<?php echo juri::root();?>/index.php?option=com_virtuemart'><?php echo JText::_('BACK_TO_SHOP_HOME'); ?></a></div>
<div class='compare-main'>
<?php  if($session_product && $counter!='0'){ ?>
    <div class='comapre-details'>
    <?php if($show_product_name == '1') {?>	
	<div class='comapre-details-inner'><?php echo JText::_('PRODUCT_NAME'); ?>  </div>
	 <?php } if($show_product_image == '1'){?>	
	<div class='comapre-details-inner-img'><?php echo JText::_('IMAGE'); ?> </div>
	<?php } if($show_product_rating == '1'){?>	
	<div class='comapre-details-inner'><?php echo JText::_('RATING'); ?> </div>
	<?php } if($show_product_price == '1'){?>	
	<div class='comapre-details-inner'><?php echo JText::_('PRICE'); ?> </div>
	<?php } if($show_product_description == '1'){?>	
	<div class='comapre-details-inner-description'><?php echo JText::_('DESCRIPTION'); ?></div>
	<?php } if($show_product_manufacture == '1'){?>	
	<div class='comapre-details-inner'><?php echo JText::_('MANUFACTURER'); ?>  </div>
	<?php } if($show_product_availability == '1'){?>	
	<div class='comapre-details-inner'><?php echo JText::_('AVAILABILITY'); ?></div>
	<?php } if($show_product_sku == '1'){?>	
	<div class='comapre-details-inner'><?php echo JText::_('PRODUCT_SKU'); ?> </div>
	<?php } if($show_product_weight == '1'){?>	
	<div class='comapre-details-inner'><?php echo JText::_('WEIGHT'); ?>  </div>
	<?php } if($show_product_addtocart == '1'){?>	
	<div class='comapre-details-inner'><?php echo JText::_('ADDCART'); ?>  </div>
	<?php } if($show_product_action == '1'){?>	
	<div class='comapre-details-inner'><?php echo JText::_('ACTION'); ?> </div>
	<?php } ?>		
    </div>
    <?php foreach($session_product->productid as $result)	
	    {
		if($result && $country)
		    {
		     
			$query = 'SELECT vpm.virtuemart_media_id, vpe.product_name, vpe.product_s_desc,vpp.product_price, vppm.virtuemart_manufacturer_id,vp.product_sku,vp.product_in_stock,vp.product_weight,vp.product_weight_uom,vr.rating  	
								    FROM #__virtuemart_product_medias As vpm
								    LEFT JOIN #__virtuemart_products_'.$country.' AS vpe ON vpe.virtuemart_product_id = vpm.virtuemart_product_id 
								    LEFT JOIN #__virtuemart_product_prices AS vpp ON vpp.virtuemart_product_id = vpm.virtuemart_product_id
								    LEFT JOIN #__virtuemart_manufacturer_medias AS vmm ON vmm.virtuemart_media_id = vpm.virtuemart_media_id
								    LEFT JOIN #__virtuemart_product_manufacturers AS vppm ON vppm.virtuemart_product_id = vpm.virtuemart_product_id
								    LEFT JOIN #__virtuemart_products AS vp ON vp.virtuemart_product_id = vpm.virtuemart_product_id
								    LEFT JOIN #__virtuemart_ratings AS vr ON vr.virtuemart_product_id = vpm.virtuemart_product_id	WHERE vpm.virtuemart_product_id ='.$result;
						    $db->setQuery($query);
						    $virtuemart_media_data = $db->loadObjectlist();
						    $rating=$virtuemart_media_data[0]->rating;
						    $product_weight_uom=$virtuemart_media_data[0]->product_weight_uom;
						    $product_weight=$virtuemart_media_data[0]->product_weight;
						    $product_in_stock=$virtuemart_media_data[0]->product_in_stock;
						    $virtuemart_manufacturer_id=$virtuemart_media_data[0]->virtuemart_manufacturer_id;
						    $product_sku=$virtuemart_media_data[0]->product_sku;
						    $product_s_desc=$virtuemart_media_data[0]->product_s_desc;
						    $product_price=$virtuemart_media_data[0]->product_price;		    
						    $virtuemart_media_id=$virtuemart_media_data[0]->virtuemart_media_id;
						    $virtuemart_product_name=$virtuemart_media_data[0]->product_name;			
					    
						    
						    $query1 = 'SELECT file_url
								    FROM #__virtuemart_medias WHERE virtuemart_media_id ='.$virtuemart_media_id;
						    $db->setQuery($query1);
						    $virtuemart_products_image = $db->loadResult();
						    
						    $query2 = 'SELECT mf_name 
								    FROM #__virtuemart_manufacturers_en_gb  WHERE virtuemart_manufacturer_id ="'.$virtuemart_manufacturer_id.'"';
						    $db->setQuery($query2);
						    $mf_name = $db->loadResult();

						    $products = $productModel->getProductSingle($result);
    
    
    ?>
    <div class='product-details'>
    	 <?php if($show_product_name == '1') {?>	
	<div class='product-details-inner'><strong><a href="index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=<?php echo $result; ?>"><?php echo $virtuemart_product_name;?></a></strong></div>
	<?php } if($show_product_image == '1'){?>	
	<div class='comapre-details-inner-img'><a href="index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=<?php echo $result; ?>"><img class='compareimg' src="<?php  echo $virtuemart_products_image;?>" /></a></div>
	<?php } if($show_product_rating == '1'){?>	
	<div class='product-details-inner'><?php
		for($i=0; $i<$rating; $i++)
		{ ?>
		<div class='goldrating'></div>
		<?php }
		
		for($j=0; $j<5-$i; $j++)
		{?>
		<div class='grayrating'></div>
		<?php }
	
				
	?></div>
	<?php } if($show_product_price == '1'){?>	
	<div class='product-details-inner'><?php 
	$wk_price = str_replace('{number}', round($product_price, 2), $wk_currency[0]['currency_positive_style']);
	$wk_price = str_replace('{symbol}', $wk_currency[0]['currency_symbol'], $wk_price);	
	echo $wk_price;
	?></div>
	<?php } if($show_product_description == '1'){?>	
	<div class='product-details-inner-description'> <?php echo $product_s_desc;?> </div>
	<?php } if($show_product_manufacture == '1'){?>	
	<div class='product-details-inner'>
	    <?php if($mf_name){ 
			  echo $mf_name; 
			  }else 
			      { 
			       echo JText::_('NA');  
			      
				}; ?> 
	</div>
	<?php } if($show_product_availability == '1'){?>	
	<div class='product-details-inner'> <?php
	if($product_in_stock=='0')
	  {
	  
	   echo '<div id="outofstock">Out of stock</div><div>'.$product_in_stock.'&nbsp'.'item(s)</div>';	   
	  }
	  else if($product_in_stock<=5)
	  {
	  echo '<div id="lowstock">Low stock</div><div>'.$product_in_stock.'&nbsp'.'item(s)</div>';
	  }
	  else
	  {	  
	  echo '<div id="instock">in stock</div><div>'.$product_in_stock.'&nbsp'.'item(s)</div>';
	  
	  }
	?> </div>
	<?php } if($show_product_sku == '1'){?>	
	<div class='product-details-inner'> <?php echo $product_sku; ?> </div>
	<?php } if($show_product_weight == '1'){?>	
	<div class='product-details-inner'> <?php echo $product_weight.'&nbsp'.$product_weight_uom; ?> </div>
	<?php } if($show_product_addtocart == '1'){?>	
	<div class='product-details-inner'> <?php echo com_compare_product::addtocart ($products); ?> </div>
	<?php } if($show_product_action == '1'){?>	
	<div class='product-details-inner remove' id='<?php echo $result;?>'> <?php echo JText::_('REMOVE');?>  </div>
    </div>
    <?php } ?>	
       <?php }  }?>
    </div>

<script type="text/javascript">
jQuery(document).ready(function(){	
jQuery(".remove").click(function(){

				  
				      jQuery.ajax({
					    url:'<?php echo JURI::root();?>components/com_virtuemartproductcompare/views/productcompare/tmpl/compare.php',
					    datatype:'JSONP',
					    data:{'product_id':this.id,'unique_id':'<?php echo $unique_id;?>','method':'remove'},
					    type:'post',
					    success:function(data){	
					    
							     location.reload();
								    
								 
					    
					    },
					    error: function(){
						    
					    }
				    });
				    });
});
</script>

<?php 
} else {

echo '<h2>'.JText::_("YOU_HAVE_NO_PRODUCT_TO_COMPARE").'</h2>'; 

}
?>