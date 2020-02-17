<?php
/*
# ------------------------------------------------------------------------
# Module: Vina Treeview for Menus
# ------------------------------------------------------------------------
# Copyright (C) 2014 www.VinaGecko.com. All Rights Reserved.
# @license http://www.gnu.org/licenseses/gpl-3.0.html GNU/GPL
# Author: VinaGecko.com
# Websites: http://VinaGecko.com
# ------------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<div id="vina-treeview-menus<?php echo $module->id; ?>" class="vina-treeview-menus">
	<?php if($params->get('showControl', 1)) { ?>
    <div id="vina-treecontrol<?php echo $module->id; ?>" class="treecontrol">
        <a href="#" title="<?php echo JTEXT::_('VINA_TREEVIEW_MENUS_COLLAPSE_ALL_DESC'); ?>"><?php echo JTEXT::_('VINA_TREEVIEW_MENUS_COLLAPSE_ALL'); ?></a> | 
        <a href="#" title="<?php echo JTEXT::_('VINA_TREEVIEW_MENUS_EXPAND_ALL_DESC'); ?>"><?php echo JTEXT::_('VINA_TREEVIEW_MENUS_EXPAND_ALL'); ?></a> | 
        <a href="#" title="<?php echo JTEXT::_('VINA_TREEVIEW_MENUS_TOGGLE_ALL_DESC'); ?>"><?php echo JTEXT::_('VINA_TREEVIEW_MENUS_TOGGLE_ALL'); ?></a>
    </div>
	<?php } ?>
	
	<ul class="level0 <?php echo $class_sfx;?> <?php echo $params->get('moduleStyle', ''); ?>"<?php
		$tag = '';
		if ($params->get('tag_id') != null)
		{
			$tag = $params->get('tag_id').'';
			echo ' id="'.$tag.'"';
		}
	?>>
	<?php
	foreach ($list as $i => &$item) :
		$class = 'item-'.$item->id;
		$folder = ($params->get('moduleStyle') == 'filetree') ? ' file' : '';
		if ($item->id == $active_id)
		{
			$class .= ' current';
		}

		if (in_array($item->id, $path))
		{
			$class .= ' active';
		}
		elseif ($item->type == 'alias')
		{
			$aliasToId = $item->params->get('aliasoptions');
			if (count($path) > 0 && $aliasToId == $path[count($path) - 1])
			{
				$class .= ' active';
			}
			elseif (in_array($aliasToId, $path))
			{
				$class .= ' alias-parent-active';
			}
		}

		if ($item->type == 'separator')
		{
			$class .= ' divider';
		}

		if ($item->deeper)
		{
			$class .= ' deeper';
		}

		if ($item->parent)
		{
			$class .= ' parent';
			$folder = ($params->get('moduleStyle') == 'filetree') ? ' folder' : '';
		}

		if (!empty($class))
		{
			$class = ' class="'.trim($class) .'"';
		}

		echo '<li'.$class.'>';

		// Render the menu item.
		switch ($item->type) :
			case 'separator':
			case 'url':
			case 'component':
			case 'heading':
				require JModuleHelper::getLayoutPath('mod_vina_treeview_menus', 'default_'.$item->type);
				break;

			default:
				require JModuleHelper::getLayoutPath('mod_vina_treeview_menus', 'default_url');
				break;
		endswitch;

		// The next item is deeper.
		if ($item->deeper)
		{
			echo '<ul class="sub-menu">';
		}
		// The next item is shallower.
		elseif ($item->shallower)
		{
			echo '</li>';
			echo str_repeat('</ul></li>', $item->level_diff);
		}
		// The next item is on the same level.
		else {
			echo '</li>';
		}
	endforeach;
	?>
	</ul>
</div>
<script type="text/javascript">
jQuery("#vina-treeview-menus<?php echo $module->id; ?> ul.level0").treeview({
	animated: 	"<?php echo $params->get('animated', 1); ?>",
	persist: 	"<?php echo $params->get('persist', 'cookie'); ?>",
	collapsed: 	<?php echo $params->get('collapsed', 1) ? "true" : "false"; ?>,
	unique:		<?php echo $params->get('unique', 1) ? "true" : "false"; ?>,
	<?php if($params->get('showControl', 1)) { ?>
	control: "#vina-treecontrol<?php echo $module->id; ?>",
	<?php } ?>
});
</script>