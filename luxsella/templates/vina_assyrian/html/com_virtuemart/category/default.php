<?php
/**
 *
 * Show the products in a category
 *
 * @package    VirtueMart
 * @subpackage
 * @author RolandD
 * @author Max Milbers
 * @todo add pagination
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 8715 2015-02-17 08:45:23Z Milbo $
 */

defined ('_JEXEC') or die('Restricted access');
?>
<?php
$app 	  = JFactory::getApplication();
$template = $app->getTemplate();

?>
<script type="text/javascript" src="<?php echo JURI::base() . 'templates/' . $template . '/js/jquery.cookie.js'; ?>"></script>
<script type="text/javascript">
jQuery(document).ready(function ($) {
	if ($.cookie('listing') == 'list') {
		$('.view-mode a').parents('.listing-view').addClass('list');
		$('.view-mode a.view-grid').removeClass('active');
		$('.view-mode a.view-list').addClass('active');
	}
});
</script>
<div class="category-view"> 
<?php
$js = "
jQuery(document).ready(function ($) {
	$('.orderlistcontainer').hover(
		function() { $(this).find('.orderlist').stop().show()},
		function() { $(this).find('.orderlist').stop().hide()}
	)
});
";
vmJsApi::addJScript('vm.hover',$js);

if (empty($this->keyword) and !empty($this->category)) {
	?>

<h2 class="category-name"><?php echo $this->category->category_name; ?></h2>
	
<div class="category_description">
	<?php echo $this->category->category_description; ?>
</div>
<?php
}

// Show child categories
if (VmConfig::get ('showCategory', 1) and empty($this->keyword)) {
	if (!empty($this->category->haschildren)) {

		echo ShopFunctionsF::renderVmSubLayout('categories',array('categories'=>$this->category->children));

	}
}

if($this->showproducts){
?>
<div id="vina-product-category" class="browse-view listing-view <?php echo  ($this->productsLayout == 'products_horizon') ? 'list' : ''; ?>">
<?php

if (!empty($this->keyword)) {
	//id taken in the view.html.php could be modified
	$category_id  = vRequest::getInt ('virtuemart_category_id', 0); ?>
	<h3 class="title-search"><?php echo JTEXT::_('VINA_SEARCH_RESULTS_FOR'); ?>: <?php echo $this->keyword; ?></h3>

	<form action="<?php echo JRoute::_ ('index.php?option=com_virtuemart&amp;view=category&amp;limitstart=0', FALSE); ?>" method="get">

		<!--BEGIN Search Box -->
		<div class="virtuemart_search">
			<?php echo $this->searchcustom ?>
			<?php echo $this->searchCustomValues ?>
			<input name="keyword" class="inputbox" type="text" size="20" value="<?php echo $this->keyword ?>"/>
			<input type="submit" value="<?php echo vmText::_ ('COM_VIRTUEMART_SEARCH') ?>" class="button" onclick="this.form.keyword.focus();"/>
		</div>
		<input type="hidden" name="search" value="true"/>
		<input type="hidden" name="view" value="category"/>
		<input type="hidden" name="option" value="com_virtuemart"/>
		<input type="hidden" name="virtuemart_category_id" value="<?php echo $category_id; ?>"/>

	</form>
	<!-- End Search Box -->
<?php  } ?>

<?php // Show child categories
	?>
	<div class="orderby-displaynumber">
			
		<div class="view-mode pull-left">
			<a href="javascript:viewMode('grid');" class="view-grid <?php echo  ($this->productsLayout	==	'products') ? 'active' : ''; ?>" title="Grid"><i class="fa fa-th-large"></i></a>
			<a href="javascript:viewMode('list');" class="view-list	<?php echo  ($this->productsLayout	==	'products_horizon') ? 'active' : ''; ?>" title="List"><i class="fa fa-th-list"></i></a>
		</div>
		
		<div class="pull-left vm-order-list">
			<?php echo $this->orderByList['orderby']; ?>
			<?php echo $this->orderByList['manufacturer']; ?>
		</div>
		
		<div class="pull-right display-number">
			<?php //echo $this->vmPagination->getResultsCounter ();?>
			<?php echo JText::_('VM_LANG_SHOW'); ?> <div class="number"><?php echo $this->vmPagination->getLimitBox ($this->category->limit_list_step); ?></div>
		</div>

		<p class="result-count pull-left">
			<?php echo $this->vmPagination->getResultsCounter ();?>
		</p>


		<div class="clear"></div>
	</div> <!-- end of orderby-displaynumber -->

	<div class="shop-products grid-view">

		<?php
		if (!empty($this->products)) {
		$products = array();
		$products[0] = $this->products;
		echo shopFunctionsF::renderVmSubLayout($this->productsLayout,array('products'=>$products,'currency'=>$this->currency,'products_per_row'=>$this->perRow,'showRating'=>$this->showRating));

		?>
	</div>


	<div class="toolbar tb-bottom">
		<?php echo $this->vmPagination->getPagesLinks (); ?>

		<div class="clearfix"></div>
	</div>

	<?php
} elseif (!empty($this->keyword)) {
	echo vmText::_ ('COM_VIRTUEMART_NO_RESULT') . ($this->keyword ? ' : (' . $this->keyword . ')' : '');
}
?>
</div>

<?php } ?>

<?php
$j = "Virtuemart.container = jQuery('.category-view');
Virtuemart.containerSelector = '.category-view';";

vmJsApi::addJScript('ajaxContent',$j);
?>
</div>
<!-- end browse-view -->