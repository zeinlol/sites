<?php
define('EXTENSION_NAME',            'Admin Quick Edit PRO');
define('EXTENSION_VERSION',         '5.4.0');
define('EXTENSION_ID',              '3805');
define('EXTENSION_COMPATIBILITY',   'OpenCart 2.1.x.x and 2.2.x.x');
define('EXTENSION_STORE_URL',       'http://www.opencart.com/index.php?route=extension/extension/info&extension_id=' . EXTENSION_ID);
define('EXTENSION_PURCHASE_URL',    'http://www.opencart.com/index.php?route=extension/purchase&extension_id=' . EXTENSION_ID);
define('EXTENSION_SUPPORT_EMAIL',   'support@opencart.ee');
define('EXTENSION_SUPPORT_FORUM',   'http://forum.opencart.com/viewtopic.php?f=123&t=45057');
define('OTHER_EXTENSIONS',          'http://www.opencart.com/index.php?route=extension/extension&filter_username=bull5-i');
define('EXTENSION_MIN_PHP_VERSION', '5.3.0');

class ControllerModuleAdminQuickEdit extends Controller {
	private $error = array();
	protected $alert = array(
		'error'     => array(),
		'warning'   => array(),
		'success'   => array(),
		'info'      => array()
	);

	private $defaults = array(
		'aqe_installed'                             => 1,
		'aqe_installed_version'                     => EXTENSION_VERSION,
		'aqe_status'                                => 0,
		'aqe_match_anywhere'                        => 0,
		'aqe_alternate_row_colour'                  => 0,
		'aqe_row_hover_highlighting'                => 0,
		'aqe_highlight_status'                      => 0,
		'aqe_interval_filter'                       => 0,
		'aqe_batch_edit'                            => 0,
		'aqe_quick_edit_on'                         => 'click',
		'aqe_list_view_image_width'                 => 40,
		'aqe_list_view_image_height'                => 40,
		'aqe_multilingual_seo'                      => 0,
		'aqe_single_language_editing'               => 0,
		'aqe_catalog_categories_status'             => 0,
		'aqe_catalog_products_status'               => 0,
		'aqe_catalog_products_filter_sub_category'  => 0,
		'aqe_catalog_recurrings_status'             => 0,
		'aqe_catalog_filters_status'                => 0,
		'aqe_catalog_attributes_status'             => 0,
		'aqe_catalog_attribute_groups_status'       => 0,
		'aqe_catalog_options_status'                => 0,
		'aqe_catalog_manufacturers_status'          => 0,
		'aqe_catalog_downloads_status'              => 0,
		'aqe_catalog_reviews_status'                => 0,
		'aqe_catalog_information_status'            => 0,
		'aqe_customer_customers_status'             => 0,
		'aqe_sales_orders_status'                   => 0,
		'aqe_sales_orders_notify_customer'          => 0,
		'aqe_sales_returns_status'                  => 0,
		'aqe_sales_returns_notify_customer'         => 0,
		'aqe_sales_voucher_themes_status'           => 0,
		'aqe_sales_vouchers_status'                 => 0,
		'aqe_marketing_campaigns_status'            => 0,
		'aqe_marketing_affiliates_status'           => 0,
		'aqe_marketing_coupons_status'              => 0,
		'aqe_services'                              => "W10=",
	);

	private $column_defaults = array(
		'aqe_catalog_products'  => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' => ''                , 'rel' => array(),           'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' => 'p.product_id'    , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'image'             => array('display' => 1, 'qe_status' => 0, 'editable' => 1, 'index' =>  10, 'align' => 'text-center', 'type' =>   'image_qe', 'sort' => ''                , 'rel' => array(),           'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'category'          => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  20, 'align' =>   'text-left', 'type' =>     'cat_qe', 'sort' => ''                , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'manufacturer'      => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  30, 'align' =>   'text-left', 'type' => 'manufac_qe', 'sort' => 'm.name'          , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'name'              => array('display' => 1, 'qe_status' => 0, 'editable' => 1, 'index' =>  40, 'align' =>   'text-left', 'type' =>    'name_qe', 'sort' => 'pd.name'         , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>  'name', 'value' => 'product_id')))),
			'tag'               => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  50, 'align' =>   'text-left', 'type' =>     'tag_qe', 'sort' => ''                , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'model'             => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  60, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.model'         , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' => 'model', 'value' => 'product_id')))),
			'price'             => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  70, 'align' =>  'text-right', 'type' =>   'price_qe', 'sort' => 'p.price'         , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'quantity'          => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  80, 'align' =>  'text-right', 'type' =>     'qty_qe', 'sort' => 'p.quantity'      , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'sku'               => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  90, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.sku'           , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'sku', 'value' => 'product_id')))),
			'upc'               => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' => 100, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.upc'           , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'upc', 'value' => 'product_id')))),
			'ean'               => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' => 110, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.ean'           , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'ean', 'value' => 'product_id')))),
			'jan'               => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' => 120, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.jan'           , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'jan', 'value' => 'product_id')))),
			'isbn'              => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' => 130, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.isbn'          , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>  'isbn', 'value' => 'product_id')))),
			'mpn'               => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' => 140, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.mpn'           , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'mpn', 'value' => 'product_id')))),
			'location'          => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' => 150, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.location'      , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => 'location'))),
			'seo'               => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' => 160, 'align' =>   'text-left', 'type' =>     'seo_qe', 'sort' => 'seo'             , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'seo', 'value' => 'product_id')))),
			'tax_class'         => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' => 170, 'align' =>   'text-left', 'type' => 'tax_cls_qe', 'sort' => 'tc.title'        , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'minimum'           => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' => 180, 'align' =>  'text-right', 'type' =>         'qe', 'sort' => 'p.minimum'       , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'subtract'          => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' => 190, 'align' => 'text-center', 'type' =>  'yes_no_qe', 'sort' => 'p.subtract'      , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'stock_status'      => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' => 200, 'align' =>   'text-left', 'type' =>   'stock_qe', 'sort' => 'ss.name'         , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'shipping'          => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' => 210, 'align' => 'text-center', 'type' =>  'yes_no_qe', 'sort' => 'p.shipping'      , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'date_added'        => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' => 215, 'align' =>   'text-left', 'type' =>'datetime_qe', 'sort' => 'p.date_added'    , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'date_available'    => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' => 220, 'align' =>   'text-left', 'type' =>    'date_qe', 'sort' => 'p.date_available', 'rel' => array(),           'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'date_modified'     => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' => 230, 'align' =>   'text-left', 'type' =>'datetime_qe', 'sort' => 'p.date_modified' , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'length'            => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' => 240, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.length'        , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'width'             => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' => 250, 'align' =>  'text-right', 'type' =>         'qe', 'sort' => 'p.width'         , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'height'            => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' => 260, 'align' =>  'text-right', 'type' =>         'qe', 'sort' => 'p.height'        , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'weight'            => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' => 270, 'align' =>  'text-right', 'type' =>         'qe', 'sort' => 'p.weight'        , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'length_class'      => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' => 280, 'align' =>   'text-left', 'type' =>  'length_qe', 'sort' => 'lc.title'        , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'weight_class'      => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' => 290, 'align' =>   'text-left', 'type' =>  'weight_qe', 'sort' => 'wc.title'        , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'points'            => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' => 300, 'align' =>  'text-right', 'type' =>         'qe', 'sort' => 'p.points'        , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'filter'            => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' => 310, 'align' =>   'text-left', 'type' =>  'filter_qe', 'sort' => ''                , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'download'          => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' => 320, 'align' =>   'text-left', 'type' =>      'dl_qe', 'sort' => ''                , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'store'             => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' => 330, 'align' =>   'text-left', 'type' =>   'store_qe', 'sort' => ''                , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'sort_order'        => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' => 340, 'align' =>  'text-right', 'type' =>         'qe', 'sort' => 'p.sort_order'    , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'status'            => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' => 350, 'align' => 'text-center', 'type' =>  'status_qe', 'sort' => 'p.status'        , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'viewed'            => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' => 360, 'align' =>  'text-right', 'type' =>         'qe', 'sort' => 'p.viewed'        , 'rel' => array(),           'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'view_in_store'     => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' => 370, 'align' =>   'text-left', 'type' =>           '', 'sort' => ''                , 'rel' => array(),           'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' => 380, 'align' =>  'text-right', 'type' =>           '', 'sort' => ''                , 'rel' => array(),           'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
		'aqe_catalog_products_actions' => array(
			'attributes'        => array('display' => 0, 'index' =>  0, 'short' => 'attr',  'type' =>    'attr_qe', 'class' =>            '', 'rel' => array()),
			'discounts'         => array('display' => 0, 'index' =>  1, 'short' => 'dscnt', 'type' =>   'dscnt_qe', 'class' =>            '', 'rel' => array()),
			'images'            => array('display' => 0, 'index' =>  2, 'short' => 'img',   'type' =>  'images_qe', 'class' =>            '', 'rel' => array()),
			'filters'           => array('display' => 0, 'index' =>  3, 'short' => 'fltr',  'type' => 'filters_qe', 'class' =>            '', 'rel' => array('filter')),
			'options'           => array('display' => 0, 'index' =>  4, 'short' => 'opts',  'type' =>  'option_qe', 'class' =>            '', 'rel' => array()),
			'recurrings'        => array('display' => 0, 'index' =>  5, 'short' => 'rec',   'type' =>   'recur_qe', 'class' =>            '', 'rel' => array()),
			'related'           => array('display' => 0, 'index' =>  6, 'short' => 'rel',   'type' => 'related_qe', 'class' =>            '', 'rel' => array()),
			'specials'          => array('display' => 0, 'index' =>  7, 'short' => 'spcl',  'type' => 'special_qe', 'class' =>            '', 'rel' => array('price')),
			'descriptions'      => array('display' => 0, 'index' =>  8, 'short' => 'desc',  'type' =>   'descr_qe', 'class' =>            '', 'rel' => array()),
			'view'              => array('display' => 1, 'index' =>  9, 'short' => 'vw',    'type' =>       'view', 'class' =>            '', 'rel' => array()),
			'edit'              => array('display' => 1, 'index' => 10, 'short' => 'ed',    'type' =>       'edit', 'class' => 'btn-primary', 'rel' => array()),
		),
		'aqe_catalog_categories' => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' =>      'cp.category_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'image'             => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  10, 'align' => 'text-center', 'type' =>   'image_qe', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'parent'            => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  15, 'align' =>   'text-left', 'type' =>  'parent_qe', 'sort' =>                'path', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false),        'rel' => array('name')),
			'name'              => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  20, 'align' =>   'text-left', 'type' =>    'name_qe', 'sort' =>                'name', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' => 'short_name', 'value' => 'category_id')))),
			'column'            => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  25, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>            'c.column', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'top'               => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  30, 'align' =>   'text-left', 'type' =>  'yes_no_qe', 'sort' =>               'c.top', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'seo'               => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  35, 'align' =>   'text-left', 'type' =>     'seo_qe', 'sort' =>                 'seo', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>        'seo', 'value' => 'category_id')))),
			'filter'            => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  40, 'align' =>   'text-left', 'type' =>  'filter_qe', 'sort' =>                    '', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'store'             => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  45, 'align' =>   'text-left', 'type' =>   'store_qe', 'sort' =>                    '', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'sort_order'        => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  50, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>        'c.sort_order', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'status'            => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  55, 'align' =>   'text-left', 'type' =>  'status_qe', 'sort' =>            'c.status', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'view_in_store'     => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>  60, 'align' =>   'text-left', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  65, 'align' =>  'text-right', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
		'aqe_catalog_recurrings' => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' =>      'r.recurring_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'name'              => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  10, 'align' =>   'text-left', 'type' =>    'name_qe', 'sort' =>             'rd.name', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'sort_order'        => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  15, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>        'r.sort_order', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'status'            => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  20, 'align' =>   'text-left', 'type' =>  'status_qe', 'sort' =>            'r.status', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'price'             => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  25, 'align' =>  'text-right', 'type' =>  'number_qe', 'sort' =>             'r.price', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'frequency'         => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  30, 'align' =>   'text-left', 'type' =>    'freq_qe', 'sort' =>         'r.frequency', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'duration'          => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  35, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>          'r.duration', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'cycle'             => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  40, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>             'r.cycle', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'trial_status'      => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  45, 'align' =>   'text-left', 'type' =>  'status_qe', 'sort' =>      'r.trial_status', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'trial_price'       => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  50, 'align' =>  'text-right', 'type' =>  'number_qe', 'sort' =>       'r.trial_price', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'trial_frequency'   => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  55, 'align' =>   'text-left', 'type' =>    'freq_qe', 'sort' =>   'r.trial_frequency', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'trial_duration'    => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  60, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>    'r.trial_duration', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'trial_cycle'       => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  65, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>       'r.trial_cycle', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  70, 'align' =>  'text-right', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
		'aqe_catalog_filters' => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' =>  'fg.filter_group_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'group_name'        => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  10, 'align' =>   'text-left', 'type' =>    'name_qe', 'sort' =>            'fgd.name', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'name', 'value' => 'filter_group_id')))),
			'filter'            => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  15, 'align' =>   'text-left', 'type' =>  'filter_qe', 'sort' =>                    '', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'name', 'value' => 'filter_id')))),
			'sort_order'        => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  20, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>       'fg.sort_order', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  25, 'align' =>  'text-right', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
		'aqe_catalog_attributes' => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' =>      'a.attribute_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'name'              => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  10, 'align' =>   'text-left', 'type' =>    'name_qe', 'sort' =>             'ad.name', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'name', 'value' => 'attribute_id')))),
			'attribute_group'   => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  15, 'align' =>   'text-left', 'type' =>   'group_qe', 'sort' =>     'attribute_group', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'sort_order'        => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  20, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>        'a.sort_order', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  25, 'align' =>  'text-right', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
		'aqe_catalog_attribute_groups' => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' =>                      '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' => 'ag.attribute_group_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'name'              => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  10, 'align' =>   'text-left', 'type' =>    'name_qe', 'sort' =>              'agd.name', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'name', 'value' => 'attribute_group_id')))),
			'sort_order'        => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  15, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>         'ag.sort_order', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  20, 'align' =>  'text-right', 'type' =>           '', 'sort' =>                      '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
		'aqe_catalog_options' => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' =>         'o.option_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'name'              => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  10, 'align' =>   'text-left', 'type' =>    'name_qe', 'sort' =>             'od.name', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'name', 'value' => 'option_id')))),
			'type'              => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  15, 'align' =>   'text-left', 'type' =>    'type_qe', 'sort' =>              'o.type', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false), 'rel' => array('option_value')),
			'option_value'      => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  20, 'align' =>   'text-left', 'type' => 'opt_val_qe', 'sort' =>                    '', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'name', 'value' => 'option_value_id')))),
			'sort_order'        => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  25, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>        'o.sort_order', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  30, 'align' =>  'text-right', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
		'aqe_catalog_manufacturers' => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' =>   'm.manufacturer_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'image'             => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  10, 'align' => 'text-center', 'type' =>   'image_qe', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'name'              => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  15, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>              'm.name', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'name', 'value' => 'manufacturer_id')))),
			'seo'               => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  20, 'align' =>   'text-left', 'type' =>     'seo_qe', 'sort' =>                 'seo', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>    'seo', 'value' => 'manufacturer_id')))),
			'store'             => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  25, 'align' =>   'text-left', 'type' =>   'store_qe', 'sort' =>                    '', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'sort_order'        => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  30, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>        'm.sort_order', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'view_in_store'     => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>  35, 'align' =>   'text-left', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  40, 'align' =>  'text-right', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
		'aqe_catalog_downloads' => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' =>       'd.download_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'name'              => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  10, 'align' =>   'text-left', 'type' =>    'name_qe', 'sort' =>             'dd.name', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'name', 'value' => 'download_id')))),
			'filename'          => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>  15, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>          'd.filename', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'mask'              => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  20, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>              'd.mask', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'date_added'        => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  25, 'align' =>  'text-right', 'type' =>           '', 'sort' =>        'd.date_added', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  30, 'align' =>  'text-right', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
		'aqe_catalog_reviews' => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' =>         'r.review_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'product'           => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  10, 'align' =>   'text-left', 'type' => 'product_qe', 'sort' =>             'pd.name', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' => 'product', 'value' => 'product_id'))), 'rel' => array('date_modified')),
			'author'            => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  15, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>            'r.author', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false), 'rel' => array('date_modified')),
			'text'              => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  20, 'align' =>   'text-left', 'type' =>    'text_qe', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false), 'rel' => array('date_modified')),
			'rating'            => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  25, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>            'r.rating', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false), 'rel' => array('date_modified')),
			'status'            => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  30, 'align' =>   'text-left', 'type' =>  'status_qe', 'sort' =>            'r.status', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false), 'rel' => array('date_modified')),
			'date_added'        => array('display' => 1, 'qe_status' => 0, 'editable' => 1, 'index' =>  35, 'align' =>   'text-left', 'type' =>    'date_qe', 'sort' =>        'r.date_added', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false), 'rel' => array('date_modified')),
			'date_modified'     => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>  40, 'align' =>   'text-left', 'type' =>           '', 'sort' =>     'r.date_modified', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  45, 'align' =>  'text-right', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
		'aqe_catalog_information' => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' =>    'i.information_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'title'             => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  10, 'align' =>   'text-left', 'type' =>   'title_qe', 'sort' =>            'id.title', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' => 'title', 'value' => 'information_id')))),
			'seo'               => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  15, 'align' =>   'text-left', 'type' =>     'seo_qe', 'sort' =>                 'seo', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>   'seo', 'value' => 'information_id')))),
			'bottom'            => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  20, 'align' =>   'text-left', 'type' =>  'yes_no_qe', 'sort' =>            'i.bottom', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'store'             => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  25, 'align' =>   'text-left', 'type' =>   'store_qe', 'sort' =>                    '', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'sort_order'        => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  30, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>        'i.sort_order', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'status'            => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  35, 'align' =>   'text-left', 'type' =>  'status_qe', 'sort' =>            'i.status', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'view_in_store'     => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>  40, 'align' =>   'text-left', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  45, 'align' =>  'text-right', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
		'aqe_customer_customers' => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' =>       'c.customer_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'name'              => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  10, 'align' =>   'text-left', 'type' =>    'name_qe', 'sort' =>                'name', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>  'name', 'value' => 'customer_id')))),
			'email'             => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  15, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>             'c.email', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' => 'email', 'value' => 'customer_id')))),
			'telephone'         => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  20, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>         'c.telephone', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'fax'               => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  25, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>               'c.fax', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'newsletter'        => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  30, 'align' =>   'text-left', 'type' =>  'yes_no_qe', 'sort' =>        'c.newsletter', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'customer_group'    => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  35, 'align' =>   'text-left', 'type' =>   'group_qe', 'sort' =>      'customer_group', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'status'            => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  40, 'align' =>   'text-left', 'type' =>  'status_qe', 'sort' =>            'c.status', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'approved'          => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  45, 'align' =>   'text-left', 'type' =>  'yes_no_qe', 'sort' =>          'c.approved', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'safe'              => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  50, 'align' =>   'text-left', 'type' =>  'yes_no_qe', 'sort' =>              'c.safe', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'ip'                => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  55, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>                'c.ip', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'date_added'        => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  60, 'align' =>   'text-left', 'type' =>    'date_qe', 'sort' =>        'c.date_added', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  65, 'align' =>  'text-right', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
		'aqe_sales_orders' => array(
			'status'            => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>   0, 'align' =>   'text-left', 'type' =>  'status_qe', 'sort' =>                    ''),
		),
		'aqe_sales_returns' => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>          '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>        'r.return_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'order_id'          => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  10, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>         'r.order_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false), 'rel' => array('date_modified')),
			'customer_id'       => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  15, 'align' =>   'text-left', 'type' =>'customer_qe', 'sort' =>      'customer_name', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' => 'full_name', 'value' => 'customer_id'))), 'rel' => array('date_modified')),
			'customer'          => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  20, 'align' =>   'text-left', 'type' =>'fullname_qe', 'sort' =>           'customer', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' => 'full_name', 'value' => 'customer_id'))), 'rel' => array('date_modified')),
			'email'             => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  25, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>            'r.email', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false), 'rel' => array('date_modified')),
			'telephone'         => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  30, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>        'r.telephone', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false), 'rel' => array('date_modified')),
			'product_id'        => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  35, 'align' =>   'text-left', 'type' => 'product_qe', 'sort' =>       'product_name', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' => 'name', 'value' => 'product_id'))), 'rel' => array('date_modified')),
			'product'           => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  40, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>          'r.product', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' => 'name', 'value' => 'product_id'))), 'rel' => array('date_modified')),
			'model'             => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  45, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>            'r.model', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false), 'rel' => array('date_modified')),
			'quantity'          => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  50, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>         'r.quantity', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false), 'rel' => array('date_modified')),
			'return_reason'     => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  55, 'align' =>   'text-left', 'type' =>  'reason_qe', 'sort' =>      'return_reason', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false), 'rel' => array('date_modified')),
			'opened'            => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  60, 'align' =>   'text-left', 'type' =>  'yes_no_qe', 'sort' =>           'r.opened', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false), 'rel' => array('date_modified')),
			'comment'           => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  65, 'align' =>   'text-left', 'type' =>    'text_qe', 'sort' =>          'r.comment', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false), 'rel' => array('date_modified')),
			'return_action'     => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  70, 'align' =>   'text-left', 'type' =>  'action_qe', 'sort' =>      'return_action', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false), 'rel' => array('date_modified')),
			'return_status'     => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  75, 'align' =>   'text-left', 'type' =>  'status_qe', 'sort' =>      'return_status', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false), 'rel' => array('date_modified')),
			'date_ordered'      => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  80, 'align' =>   'text-left', 'type' =>    'date_qe', 'sort' =>     'r.date_ordered', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false), 'rel' => array('date_modified')),
			'date_added'        => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  85, 'align' =>   'text-left', 'type' =>    'date_qe', 'sort' =>       'r.date_added', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false), 'rel' => array('date_modified')),
			'date_modified'     => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  90, 'align' =>   'text-left', 'type' =>           '', 'sort' =>    'r.date_modified', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  95, 'align' =>  'text-right', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
		'aqe_sales_vouchers' => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' =>        'v.voucher_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'code'              => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  10, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>              'v.code', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'from_name'         => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  15, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>         'v.from_name', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'from_email'        => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  20, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>        'v.from_email', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'to_name'           => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  25, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>           'v.to_name', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'to_email'          => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  30, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>          'v.to_email', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'amount'            => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  35, 'align' =>  'text-right', 'type' =>  'amount_qe', 'sort' =>            'v.amount', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'theme'             => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  40, 'align' =>   'text-left', 'type' =>   'theme_qe', 'sort' =>               'theme', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'message'           => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  45, 'align' =>   'text-left', 'type' =>    'text_qe', 'sort' =>                    '', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'status'            => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  50, 'align' =>   'text-left', 'type' =>  'status_qe', 'sort' =>            'v.status', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'date_added'        => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  55, 'align' =>   'text-left', 'type' =>    'date_qe', 'sort' =>        'v.date_added', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  60, 'align' =>  'text-right', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
		'aqe_sales_voucher_themes' => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' => 'vt.voucher_theme_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'image'             => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  10, 'align' => 'text-center', 'type' =>   'image_qe', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'name'              => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  15, 'align' =>   'text-left', 'type' =>    'name_qe', 'sort' =>            'vtd.name', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  20, 'align' =>  'text-right', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
		'aqe_marketing_campaigns' => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' =>      'm.marketing_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'name'              => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  10, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>              'm.name', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'description'       => array('display' => 0, 'qe_status' => 1, 'editable' => 1, 'index' =>  15, 'align' =>   'text-left', 'type' =>    'text_qe', 'sort' =>       'm.description', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'code'              => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  20, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>              'm.code', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'clicks'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  25, 'align' =>  'text-right', 'type' =>           '', 'sort' =>            'm.clicks', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'orders'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  30, 'align' =>  'text-right', 'type' =>           '', 'sort' =>              'orders', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'date_added'        => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  35, 'align' =>   'text-left', 'type' =>    'date_qe', 'sort' =>        'm.date_added', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  40, 'align' =>  'text-right', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
		'aqe_marketing_affiliates' => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' =>      'a.affiliate_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'name'              => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  10, 'align' =>   'text-left', 'type' =>    'name_qe', 'sort' =>                'name', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' =>  'name', 'value' => 'affiliate_id')))),
			'email'             => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  15, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>             'a.email', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => array('return' => array('label' => 'email', 'value' => 'affiliate_id')))),
			'telephone'         => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  20, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>         'a.telephone', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'fax'               => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  25, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>               'a.fax', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'company'           => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  30, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>           'a.company', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'address_1'         => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  35, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>         'a.address_1', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'address_2'         => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  40, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>         'a.address_2', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'city'              => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  45, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>              'a.city', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'postcode'          => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  50, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>          'a.postcode', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'country'           => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  55, 'align' =>   'text-left', 'type' => 'country_qe', 'sort' =>             'country', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'region'            => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  60, 'align' =>   'text-left', 'type' =>  'region_qe', 'sort' =>              'region', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'tracking_code'     => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  65, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>              'a.code', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'commission'        => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  70, 'align' =>  'text-right', 'type' =>  'number_qe', 'sort' =>        'a.commission', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'tax'               => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  75, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>               'a.tax', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'balance'           => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  80, 'align' =>  'text-right', 'type' =>  'number_qe', 'sort' =>             'balance', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'approved'          => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  85, 'align' =>   'text-left', 'type' =>  'yes_no_qe', 'sort' =>          'a.approved', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'date_added'        => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  90, 'align' =>   'text-left', 'type' =>    'date_qe', 'sort' =>        'a.date_added', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'ip'                => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  95, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>                'a.ip', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'status'            => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' => 100, 'align' =>   'text-left', 'type' =>  'status_qe', 'sort' =>            'a.status', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' => 105, 'align' =>  'text-right', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
		'aqe_marketing_coupons' => array(
			'selector'          => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
			'id'                => array('display' => 0, 'qe_status' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' =>         'c.coupon_id', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'name'              => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  10, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>              'c.name', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'code'              => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  15, 'align' =>   'text-left', 'type' =>         'qe', 'sort' =>              'c.code', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'type'              => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  20, 'align' =>   'text-left', 'type' =>    'type_qe', 'sort' =>              'c.type', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'total'             => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  25, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>             'c.total', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'products'          => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  30, 'align' =>   'text-left', 'type' =>    'prod_qe', 'sort' =>                    '', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'categories'        => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  35, 'align' =>   'text-left', 'type' =>     'cat_qe', 'sort' =>                    '', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'logged'            => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  40, 'align' =>   'text-left', 'type' =>  'yes_no_qe', 'sort' =>            'c.logged', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'shipping'          => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  45, 'align' =>   'text-left', 'type' =>  'yes_no_qe', 'sort' =>          'c.shipping', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'discount'          => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  50, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>          'c.discount', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'date_start'        => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  55, 'align' =>   'text-left', 'type' =>    'date_qe', 'sort' =>        'c.date_start', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'date_end'          => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  60, 'align' =>   'text-left', 'type' =>    'date_qe', 'sort' =>          'c.date_end', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'uses_total'        => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  65, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>        'c.uses_total', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'uses_customer'     => array('display' => 0, 'qe_status' => 0, 'editable' => 1, 'index' =>  70, 'align' =>  'text-right', 'type' =>         'qe', 'sort' =>     'c.uses_customer', 'filter' => array('show' => 1, 'type' => 0, 'autocomplete' => false)),
			'status'            => array('display' => 1, 'qe_status' => 1, 'editable' => 1, 'index' =>  75, 'align' =>   'text-left', 'type' =>  'status_qe', 'sort' =>            'c.status', 'filter' => array('show' => 1, 'type' => 1, 'autocomplete' => false)),
			'action'            => array('display' => 1, 'qe_status' => 0, 'editable' => 0, 'index' =>  80, 'align' =>  'text-right', 'type' =>           '', 'sort' =>                    '', 'filter' => array('show' => 0, 'type' => 0, 'autocomplete' => false)),
		),
	);

	private static $language_texts = array(
		// Texts
		'text_enabled', 'text_disabled', 'text_yes', 'text_no', 'text_toggle_navigation', 'text_legal_notice', 'text_license', 'text_extension_information',
		'text_terms', 'text_license_text', 'text_support_subject', 'text_faq', 'text_display', 'text_editable', 'text_column_name', 'text_button',
		'text_single_click', 'text_double_click', 'text_select_all', 'text_saving', 'text_upgrading', 'text_loading', 'text_canceling',
		// Txts
		'txt_action', 'txt_address_1', 'txt_address_2', 'txt_amount', 'txt_approved', 'txt_attribute_group', 'txt_author', 'txt_balance', 'txt_bottom',
		'txt_categories', 'txt_category', 'txt_city', 'txt_clicks', 'txt_code', 'txt_column', 'txt_comment', 'txt_commission', 'txt_company', 'txt_country',
		'txt_customer', 'txt_customer_group', 'txt_customer_id', 'txt_cycle', 'txt_date_added', 'txt_date_available', 'txt_date_end', 'txt_date_modified',
		'txt_date_ordered', 'txt_date_start', 'txt_description', 'txt_discount', 'txt_download', 'txt_duration', 'txt_ean', 'txt_email', 'txt_fax',
		'txt_filename', 'txt_filter', 'txt_frequency', 'txt_from_email', 'txt_from_name', 'txt_group_name', 'txt_height', 'txt_image', 'txt_id', 'txt_ip',
		'txt_isbn', 'txt_jan', 'txt_length', 'txt_length_class', 'txt_location', 'txt_logged', 'txt_manufacturer', 'txt_mask', 'txt_message', 'txt_minimum',
		'txt_model', 'txt_mpn', 'txt_name', 'txt_newsletter', 'txt_opened', 'txt_option_value', 'txt_order_id', 'txt_orders', 'txt_points', 'txt_postcode',
		'txt_price', 'txt_parent', 'txt_product', 'txt_product_id', 'txt_products', 'txt_quantity', 'txt_rating', 'txt_region', 'txt_requires_shipping',
		'txt_return_id', 'txt_return_action', 'txt_return_reason', 'txt_return_status', 'txt_safe', 'txt_selector', 'txt_seo', 'txt_shipping', 'txt_sku',
		'txt_sort_order', 'txt_status', 'txt_stock_status', 'txt_store', 'txt_subtract', 'txt_tag', 'txt_tax', 'txt_tax_class', 'txt_telephone', 'txt_text',
		'txt_theme', 'txt_title', 'txt_to_email', 'txt_to_name', 'txt_top', 'txt_total', 'txt_tracking_code', 'txt_trial_cycle', 'txt_trial_duration',
		'txt_trial_frequency', 'txt_trial_price', 'txt_trial_status', 'txt_type', 'txt_upc', 'txt_uses_customer', 'txt_uses_total', 'txt_view_in_store',
		'txt_weight', 'txt_weight_class', 'txt_width',

		'txt_attributes', 'txt_discounts', 'txt_images', 'txt_filters', 'txt_options', 'txt_recurrings', 'txt_related', 'txt_specials', 'txt_descriptions',
		'txt_view', 'txt_edit',
		// Tabs
		'tab_settings', 'tab_support', 'tab_about', 'tab_general', 'tab_faq', 'tab_services', 'tab_changelog', 'tab_extension', 'tab_catalog', 'tab_sales',
		'tab_marketing', 'tab_categories', 'tab_products', 'tab_recurrings', 'tab_filters', 'tab_attributes', 'tab_attribute_groups', 'tab_options',
		'tab_manufacturers', 'tab_downloads', 'tab_reviews', 'tab_information', 'tab_orders', 'tab_returns', 'tab_customers', 'tab_voucher_themes',
		'tab_vouchers', 'tab_campaigns', 'tab_affiliates', 'tab_coupons', 'tab_customer',
		// Buttons
		'button_save', 'button_apply', 'button_cancel', 'button_close', 'button_upgrade', 'button_refresh',
		// Help texts
		'help_match_anywhere', 'help_alternate_row_colour', 'help_row_hover_highlighting', 'help_highlight_status', 'help_interval_filter', 'help_batch_edit',
		'help_filter_sub_category', 'help_columns', 'help_actions',
		// Entries
		'entry_installed_version', 'entry_extension_status', 'entry_extension_name', 'entry_extension_compatibility', 'entry_extension_store_url',
		'entry_copyright_notice', 'entry_match_anywhere', 'entry_alternate_row_colour', 'entry_row_hover_highlighting', 'entry_highlight_status',
		'entry_interval_filter', 'entry_quick_edit_on', 'entry_batch_edit', 'entry_list_view_image_size', 'entry_fields', 'entry_actions',
		'entry_single_language_editing', 'entry_catalog_categories_status', 'entry_catalog_products_status', 'entry_catalog_products_filter_sub_category',
		'entry_catalog_recurrings_status', 'entry_catalog_filters_status', 'entry_catalog_attributes_status', 'entry_catalog_attribute_groups_status',
		'entry_catalog_options_status', 'entry_catalog_manufacturers_status', 'entry_catalog_downloads_status', 'entry_catalog_reviews_status',
		'entry_catalog_information_status', 'entry_sales_orders_status', 'entry_sales_returns_status', 'entry_customer_customers_status',
		'entry_sales_voucher_themes_status', 'entry_sales_vouchers_status', 'entry_marketing_campaigns_status', 'entry_marketing_affiliates_status',
		'entry_marketing_coupons_status', 'entry_notify_customer',
		// Errors
		'error_ajax_request', 'error_image_width', 'error_image_height'
	);

	public function __construct($registry) {
		parent::__construct($registry);
		$this->load->helper('aqe');

		$this->load->language('module/admin_quick_edit');
	}

	public function index() {
		$this->document->addStyle('view/stylesheet/aqe/css/module.min.css');

		$this->document->addScript('view/javascript/aqe/module.min.js');

		$this->document->setTitle($this->language->get('extension_name'));

		$this->load->model('setting/setting');

		$ajax_request = isset($this->request->server['HTTP_X_REQUESTED_WITH']) && !empty($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && !$ajax_request && $this->validateForm($this->request->post)) {
			$original_settings = $this->model_setting_setting->getSetting('aqe');

			foreach ($this->defaults as $setting => $default) {
				$value = $this->config->get($setting);
				if ($value === null) {
					$original_settings[$setting] = $default;
				}
			}

			foreach ($this->column_defaults as $page => $columns) {
				$page_conf = $this->config->get($page);

				if ($page_conf === null) {
					$page_conf = $value;
				}

				foreach ($columns as $column => $attributes) {
					if (!isset($page_conf[$column])) {
						$page_conf[$column] = $attributes;
					} else {
						foreach ($attributes as $key => $value) {
							if (!isset($page_conf[$column][$key])) {
								$page_conf[$column][$key] = $value;
							} else {
								switch ($key) {
									case 'display':
										$page_conf[$column][$key] = (isset($this->request->post['display'][$page][$column])) ? 1 : 0;
										break;
									case 'index':
										$page_conf[$column][$key] = (isset($this->request->post['index'][$page][$column])) ? $this->request->post['index'][$page][$column] : $value;
										break;
									case 'qe_status':
										$page_conf[$column][$key] = (isset($this->request->post['qe_status'][$page][$column])) ? 1 : 0;
										break;
									default:
										$page_conf[$column][$key] = $value;
										break;
								}
							}
						}

						foreach (array_diff(array_keys($page_conf[$column]), array_keys($columns[$column])) as $key) {
							unset($page_conf[$column]);
						}
					}
				}

				foreach (array_diff(array_keys($page_conf), array_keys($columns)) as $key) {
					unset($page_conf[$key]);
				}

				$this->request->post[$page] = $page_conf;
			}

			unset($this->request->post['index']);
			unset($this->request->post['display']);
			unset($this->request->post['qe_status']);

			$settings = array_merge($original_settings, $this->request->post);
			$settings['aqe_installed_version'] = $original_settings['aqe_installed_version'];

			$settings['aqe_list_view_image_width'] = (int)$settings['aqe_list_view_image_width'];
			$settings['aqe_list_view_image_height'] = (int)$settings['aqe_list_view_image_height'];

			$this->model_setting_setting->editSetting('aqe', $settings);

			$this->session->data['success'] = $this->language->get('text_success_update');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
		} else if ($this->request->server['REQUEST_METHOD'] == 'POST' && $ajax_request) {
			$response = array();

			if ($this->validateForm($this->request->post)) {
				$original_settings = $this->model_setting_setting->getSetting('aqe');

				foreach ($this->defaults as $setting => $default) {
					$value = $this->config->get($setting);
					if ($value === null) {
						$original_settings[$setting] = $default;
					}
				}

				foreach ($this->column_defaults as $page => $columns) {
					$page_conf = $this->config->get($page);

					if ($page_conf === null) {
						$page_conf = $value;
					}

					foreach ($columns as $column => $attributes) {
						if (!isset($page_conf[$column])) {
							$page_conf[$column] = $attributes;
						} else {
							foreach ($attributes as $key => $value) {
								if (!isset($page_conf[$column][$key])) {
									$page_conf[$column][$key] = $value;
								} else {
									switch ($key) {
										case 'display':
											$page_conf[$column][$key] = (isset($this->request->post['display'][$page][$column])) ? 1 : 0;
											break;
										case 'index':
											$page_conf[$column][$key] = (isset($this->request->post['index'][$page][$column])) ? $this->request->post['index'][$page][$column] : $value;
											break;
										case 'qe_status':
											$page_conf[$column][$key] = (isset($this->request->post['qe_status'][$page][$column])) ? 1 : 0;
											break;
										default:
											$page_conf[$column][$key] = $value;
											break;
									}
								}
							}

							foreach (array_diff(array_keys($page_conf[$column]), array_keys($columns[$column])) as $key) {
								unset($page_conf[$column][$key]);
							}
						}
					}

					foreach (array_diff(array_keys($page_conf), array_keys($columns)) as $key) {
						unset($page_conf[$key]);
					}

					$this->request->post[$page] = $page_conf;
				}

				unset($this->request->post['index']);
				unset($this->request->post['display']);
				unset($this->request->post['qe_status']);

				$settings = array_merge($original_settings, $this->request->post);
				$settings['aqe_installed_version'] = $original_settings['aqe_installed_version'];

				$settings['aqe_list_view_image_width'] = (int)$settings['aqe_list_view_image_width'];
				$settings['aqe_list_view_image_height'] = (int)$settings['aqe_list_view_image_height'];

				if ((int)$original_settings['aqe_status'] != (int)$this->request->post['aqe_status']) {
					$response['reload'] = true;
					$this->session->data['success'] = $this->language->get('text_success_update');
				}

				$this->model_setting_setting->editSetting('aqe', $settings);

				$response['success'] = true;
				$response['msg'] = $this->language->get("text_success_update");
			} else {
				if (!$this->checkVersion()) {
					$response['reload'] = true;
				}
				$response = array_merge($response, array("error" => true), array("errors" => $this->error), array("alerts" => $this->alert));
			}

			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_enc($response, JSON_UNESCAPED_SLASHES));
			return;
		}

		$this->checkPrerequisites();

		$this->checkVersion();

		$data['heading_title'] = $this->language->get('extension_name');
		$data['text_other_extensions'] = sprintf($this->language->get('text_other_extensions'), OTHER_EXTENSIONS);

		foreach (self::$language_texts as $text) {
			$data[$text] = $this->language->get($text);
		}

		$data['ext_name'] = EXTENSION_NAME;
		$data['ext_version'] = EXTENSION_VERSION;
		$data['ext_id'] = EXTENSION_ID;
		$data['ext_compatibility'] = EXTENSION_COMPATIBILITY;
		$data['ext_store_url'] = EXTENSION_STORE_URL;
		$data['ext_purchase_url'] = EXTENSION_PURCHASE_URL;
		$data['ext_support_email'] = EXTENSION_SUPPORT_EMAIL;
		$data['ext_support_forum'] = EXTENSION_SUPPORT_FORUM;
		$data['other_extensions_url'] = OTHER_EXTENSIONS;

		$data['alert_icon'] = function($type) {
			$icon = "";
			switch ($type) {
				case 'error':
					$icon = "fa-times-circle";
					break;
				case 'warning':
					$icon = "fa-exclamation-triangle";
					break;
				case 'success':
					$icon = "fa-check-circle";
					break;
				case 'info':
					$icon = "fa-info-circle";
					break;
				default:
					break;
			}
			return $icon;
		};

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true),
			'active'    => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], true),
			'active'    => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('extension_name'),
			'href'      => $this->url->link('module/admin_quick_edit', 'token=' . $this->session->data['token'], true),
			'active'    => true
		);

		$data['save'] = $this->url->link('module/admin_quick_edit', 'token=' . $this->session->data['token'], true);
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);
		$data['upgrade'] = $this->url->link('module/admin_quick_edit/upgrade', 'token=' . $this->session->data['token'], true);
		$data['extension_installer'] = $this->url->link('extension/installer', 'token=' . $this->session->data['token'], true);
		$data['services'] = html_entity_decode($this->url->link('module/admin_quick_edit/services', 'token=' . $this->session->data['token'], true));

		$data['update_pending'] = !$this->checkVersion();

		if (!$data['update_pending']) {
			$this->updateEventHooks();
		}

		$data['ssl'] = (
				(int)$this->config->get('config_secure') ||
				isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ||
				!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ||
				!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on'
			) ? 's' : '';

		# Loop through all settings for the post/config values
		foreach (array_keys($this->defaults) as $setting) {
			if (isset($this->request->post[$setting])) {
				$data[$setting] = $this->request->post[$setting];
			} else {
				$data[$setting] = $this->config->get($setting);
				if ($data[$setting] === null) {
					if (!isset($this->alert['warning']['unsaved']) && $this->checkVersion())  {
						$this->alert['warning']['unsaved'] = $this->language->get('error_unsaved_settings');
					}
					if (isset($this->defaults[$setting])) {
						$data[$setting] = $this->defaults[$setting];
					}
				}
			}
		}

		// Check for multistore setup
		$this->load->model('setting/store');

		$multistore = $this->model_setting_store->getTotalStores();

		// Check for multilingual SEO keywords
		$column = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "url_alias` LIKE '%language_id'");
		if ($column->num_rows && isset($column->row['Field'])) {
			$multilingual_seo = $column->row['Field'];
		} else {
			$multilingual_seo = false;
		}

		if ($data['aqe_multilingual_seo'] != $multilingual_seo) {
			$data['aqe_multilingual_seo'] = $multilingual_seo;
			if (!isset($this->alert['warning']['unsaved']) && $this->checkVersion())  {
				$this->alert['warning']['unsaved'] = $this->language->get('error_unsaved_settings');
			}
		}

		$data['installed_version'] = $this->installedVersion();

		foreach ($this->column_defaults as $page => $columns) {
			$conf = $this->config->get($page);
			if (!is_array($conf)) {
				if (!isset($this->alert['warning']['unsaved']) && $this->checkVersion())  {
					$this->alert['warning']['unsaved'] = $this->language->get('error_unsaved_settings');
				}
				$conf = $columns;
			}

			foreach ($columns as $column => $attributes) {
				if (!isset($conf[$column])) {
					if (!isset($this->alert['warning']['unsaved']) && $this->checkVersion())  {
						$this->alert['warning']['unsaved'] = $this->language->get('error_unsaved_settings');
					}
					$conf[$column] = $attributes;
				}

				foreach ($attributes as $key => $value) {
					if (!isset($conf[$column][$key])) {
						if (!isset($this->alert['warning']['unsaved']) && $this->checkVersion())  {
							$this->alert['warning']['unsaved'] = $this->language->get('error_unsaved_settings');
						}
						$conf[$column][$key] = $value;
					}
					switch ($key) {
						case 'display':
						case 'qe_status':
						case 'index':
							break;
						default:
							if ($conf[$column][$key] != $value) {
								if (!isset($this->alert['warning']['unsaved']) && $this->checkVersion())  {
									$this->alert['warning']['unsaved'] = $this->language->get('error_unsaved_settings');
								}
							}
							break;
					}
				}

				if (array_diff(array_keys($conf[$column]), array_keys($columns[$column])) && !isset($this->alert['warning']['unsaved']) && $this->checkVersion()) {
					$this->alert['warning']['unsaved'] = $this->language->get('error_unsaved_settings');
				}

				$conf[$column]['name'] = $this->language->get('txt_' . $column);;

				if ($column == 'view_in_store' && !$multistore) {
					unset($conf[$column]);
				}
			}

			if (array_diff(array_keys($conf), array_keys($columns)) && !isset($this->alert['warning']['unsaved']) && $this->checkVersion()) {
				$this->alert['warning']['unsaved'] = $this->language->get('error_unsaved_settings');
			}

			uasort($conf, 'column_sort');
			$data[$page] = $conf;
		}

		if (isset($this->session->data['error'])) {
			$this->error = $this->session->data['error'];

			unset($this->session->data['error']);
		}

		if (isset($this->error['warning'])) {
			$this->alert['warning']['warning'] = $this->error['warning'];
		}

		if (isset($this->error['error'])) {
			$this->alert['error']['error'] = $this->error['error'];
		}

		if (isset($this->session->data['success'])) {
			$this->alert['success']['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		}

		$data['errors'] = $this->error;

		$data['token'] = $this->session->data['token'];

		$data['alerts'] = $this->alert;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		if (version_compare(VERSION, '2.2.0', '>=')) {
			$template = 'module/admin_quick_edit';
		} else {
			$template = 'module/admin_quick_edit.tpl';
		}
		$this->response->setOutput($this->load->view($template, $data));
	}

	public function install() {
		$this->registerEventHooks();

		$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting('aqe', array_merge($this->defaults, $this->column_defaults));
	}

	public function uninstall() {
		$this->removeEventHooks();

		$this->load->model('setting/setting');
		$this->model_setting_setting->deleteSetting('aqe');
	}

	public function upgrade() {
		$ajax_request = isset($this->request->server['HTTP_X_REQUESTED_WITH']) && !empty($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

		$response = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateUpgrade()) {
			$this->load->model('setting/setting');

			$settings = array();

			// Go over all settings, add new values and remove old ones
			foreach ($this->defaults as $setting => $default) {
				$value = $this->config->get($setting);
				if ($value === null) {
					$settings[$setting] = $default;
				} else {
					$settings[$setting] = $value;
				}
			}

			foreach ($this->column_defaults as $page => $columns) {
				$setting = array();

				$conf = $this->config->get($page);

				if ($conf === null || !is_array($conf)) {
					$conf = $columns;
				}

				foreach ($columns as $column => $values) {
					$setting[$column] = array();

					foreach ($values as $key => $value) {
						if (!isset($conf[$column][$key])) {
							$setting[$column][$key] = $value;
						} else {
							$setting[$column][$key] = $conf[$column][$key];
						}
					}
				}

				$settings[$page] = $setting;
			}

			$settings['aqe_installed_version'] = EXTENSION_VERSION;

			$this->model_setting_setting->editSetting('aqe', $settings);

			$this->session->data['success'] = sprintf($this->language->get('text_success_upgrade'), EXTENSION_VERSION);
			$this->alert['success']['upgrade'] = sprintf($this->language->get('text_success_upgrade'), EXTENSION_VERSION);

			$response['success'] = true;
			$response['reload'] = true;
		}

		$response = array_merge($response, array("errors" => $this->error), array("alerts" => $this->alert));

		if (!$ajax_request) {
			$this->session->data['errors'] = $this->error;
			$this->session->data['alerts'] = $this->alert;
			$this->response->redirect($this->url->link('module/admin_quick_edit', 'token=' . $this->session->data['token'], true));
		} else {
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_enc($response, JSON_UNESCAPED_SLASHES));
			return;
		}
	}

	public function services() {
		$services = base64_decode($this->config->get('aqe_services'));
		$response = json_decode($services, true);
		$force = isset($this->request->get['force']) && (int)$this->request->get['force'];

		if ($response && isset($response['expires']) && $response['expires'] >= strtotime("now") && !$force) {
			$response['cached'] = true;
		} else {
			$url = "http://www.opencart.ee/services/?eid=" . EXTENSION_ID . "&info=true&general=true";
			$hostname = (!empty($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : '' ;

			if (function_exists('curl_init')) {
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
				curl_setopt($ch, CURLOPT_TIMEOUT, 60);
				curl_setopt($ch, CURLOPT_USERAGENT, base64_encode("curl " . EXTENSION_ID));
				curl_setopt($ch, CURLOPT_REFERER, $hostname);
				$json = curl_exec($ch);
			} else {
				$json = false;
			}

			if ($json !== false) {
				$this->load->model('setting/setting');
				$settings = $this->model_setting_setting->getSetting('aqe');
				$settings['aqe_services'] = base64_encode($json);
				$this->model_setting_setting->editSetting('aqe', $settings);
				$response = json_decode($json, true);
			} else {
				$response = array();
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_enc($response, JSON_UNESCAPED_SLASHES));
	}

	private function registerEventHooks() {
		if (version_compare(VERSION, '2.0.1', '<')) {
			// $this->load->model('tool/event');
			// $this->model_tool_event->addEvent('pqe.product.add', 'post.admin.add.product', 'catalog/product_ext/clear_products_cache');
		} else {
			// $this->load->model('extension/event');
			// $this->model_extension_event->addEvent('pqe.product.add', 'post.admin.product.add', 'catalog/product_ext/clear_products_cache');
		}
	}

	private function removeEventHooks() {
		if (version_compare(VERSION, '2.0.1', '<')) {
			// $this->load->model('tool/event');
			// $this->model_tool_event->deleteEvent('pqe.product.add');
		} else {
			// $this->load->model('extension/event');
			// $this->model_extension_event->deleteEvent('pqe.product.add');
		}
	}

	private function updateEventHooks() {
		if (version_compare(VERSION, '2.0.1', '<')) {
			$this->load->model('tool/event');
		} else {
			$this->load->model('extension/event');
		}

		if (version_compare(VERSION, '2.0.1', '<')) {
			$event_hooks = array(
				// 'pqe.product.add'           => array('trigger' => 'post.admin.add.product',           'action' => 'catalog/product_ext/clear_products_cache'),
			);
		} else {
			$event_hooks = array(
				// 'pqe.product.add'           => array('trigger' => 'post.admin.product.add',           'action' => 'catalog/product_ext/clear_products_cache'),
			);
		}

		foreach ($event_hooks as $code => $hook) {
			if (version_compare(VERSION, '2.0.1', '<')) {
				$event = $this->model_tool_event->getEvent($code);
			} else {
				$event = $this->model_extension_event->getEvent($code);
			}

			if (!$event || $event['trigger'] != $hook['trigger'] || $event['action'] != $hook['action']) {
				if (version_compare(VERSION, '2.0.1', '<')) {
					$this->model_tool_event->addEvent($code, $hook['trigger'], $hook['action']);
				} else {
					$this->model_extension_event->addEvent($code, $hook['trigger'], $hook['action']);
				}

				if (empty($this->alert['success']['hooks_updated'])) {
					$this->alert['success']['hooks_updated'] = $this->language->get('text_success_hooks_update');
				}
			}
		}

		// Delete old triggers
		$query = $this->db->query("SELECT `code` FROM " . DB_PREFIX . "event WHERE `code` LIKE 'pqe.%'");
		$events = array_keys($event_hooks);

		foreach ($query->rows as $row) {
			if (!in_array($row['code'], $events)) {
				if (version_compare(VERSION, '2.0.1', '<')) {
					$this->model_tool_event->deleteEvent($row['code']);
				} else {
					$this->model_extension_event->deleteEvent($row['code']);
				}

				if (empty($this->alert['success']['hooks_updated'])) {
					$this->alert['success']['hooks_updated'] = $this->language->get('text_success_hooks_update');
				}
			}
		}
	}

	private function checkPrerequisites() {
		$errors = false;

		if (version_compare(phpversion(), EXTENSION_MIN_PHP_VERSION) < 0) {
			$errors = true;
			$this->alert['error']['php'] = sprintf($this->language->get('error_php_version'), phpversion(), EXTENSION_MIN_PHP_VERSION);
		}

		if (!defined('MOD_ACTIVE')) {
			$this->alert['warning']['modification'] = $this->language->get('error_modification');
		}

		return !$errors;
	}

	private function checkVersion() {
		$errors = false;

		$installed_version = $this->installedVersion();

		if ($installed_version != EXTENSION_VERSION) {
			$errors = true;
			$this->alert['info']['version'] = sprintf($this->language->get('error_version'), EXTENSION_VERSION);
		}

		return !$errors;
	}

	private function validate() {
		$errors = false;

		if (!$this->user->hasPermission('modify', 'module/admin_quick_edit')) {
			$errors = true;
			$this->alert['error']['permission'] = $this->language->get('error_permission');
		}

		if (!$errors) {
			return $this->checkVersion() && $this->checkPrerequisites();
		} else {
			return false;
		}
	}

	private function validateForm($data) {
		$errors = false;

		if (!$data['aqe_list_view_image_width'] || !is_numeric($this->request->post['aqe_list_view_image_width']) || (int)$this->request->post['aqe_list_view_image_width'] < 1) {
			$errors = true;
			$this->error['list_view_image_width'] = $this->language->get('error_image_width');
		}

		if (!$data['aqe_list_view_image_height'] || !is_numeric($this->request->post['aqe_list_view_image_height']) || (int)$this->request->post['aqe_list_view_image_height'] < 1) {
			$errors = true;
			$this->error['list_view_image_height'] = $this->language->get('error_image_height');
		}

		if ($errors) {
			$errors = true;
			$this->alert['warning']['warning'] = $this->language->get('error_warning');
		}

		if (!$errors) {
			return $this->validate();
		} else {
			return false;
		}
	}

	private function validateUpgrade() {
		$errors = false;

		if (!$this->user->hasPermission('modify', 'module/admin_quick_edit')) {
			$errors = true;
			$this->alert['error']['permission'] = $this->language->get('error_permission');
		}

		return !$errors;
	}

	private function installedVersion() {
		$installed_version = $this->config->get('aqe_installed_version');
		return $installed_version ? $installed_version : '3.5.4';
	}
}
