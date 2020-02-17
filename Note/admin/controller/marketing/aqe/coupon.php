<?php
class ControllerMarketingAqeCoupon extends Controller {
	protected $error = array();
	protected $alert = array(
		'error'     => array(),
		'warning'   => array(),
		'success'   => array(),
		'info'      => array()
	);

	public function __construct($registry) {
		parent::__construct($registry);
		$this->load->helper('aqe');

		$this->load->model('marketing/coupon');
		$this->load->model('marketing/aqe/coupon');

		$this->load->language('marketing/coupon');
		$this->load->language('marketing/aqe/general');
		$this->load->language('marketing/aqe/coupon');

		if (!$this->config->get('aqe_installed') || !$this->config->get('aqe_status')) {
			$this->response->redirect($this->url->link('marketing/coupon', 'token=' . $this->session->data['token'], true));
		}
	}

	public function index() {
		$this->document->setTitle($this->language->get('heading_title'));

		$this->getList();
	}

	public function delete() {
		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $item_id) {
				$this->model_marketing_coupon->deleteCoupon($item_id);
			}

			$this->session->data['success'] = sprintf($this->language->get('text_success_delete'), count($this->request->post['selected']));

			$url = '';

			foreach($this->config->get('aqe_marketing_coupons') as $column => $attr) {
				if (isset($this->request->get['filter_' . $column])) {
					$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
				}
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('marketing/coupon', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_percent'] = $this->language->get('text_percent');
		$data['text_amount'] = $this->language->get('text_amount');
		$data['text_saving'] = $this->language->get('text_saving');
		$data['text_deleting'] = $this->language->get('text_deleting');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_batch_edit'] = $this->language->get('text_batch_edit');
		$data['text_autocomplete'] = $this->language->get('text_autocomplete');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_clear_filter'] = $this->language->get('text_clear_filter');
		$data['text_filter'] = $this->language->get('text_filter');
		$data['text_confirm_delete'] = $this->language->get('text_confirm_delete');
		$data['text_are_you_sure'] = $this->language->get('text_are_you_sure');
		$data['text_toggle_navigation'] = $this->language->get('text_toggle_navigation');
		$data['text_toggle_dropdown'] = $this->language->get('text_toggle_dropdown');

		$data['column_id'] = $this->language->get('column_id');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_code'] = $this->language->get('column_code');
		$data['column_type'] = $this->language->get('column_type');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_products'] = $this->language->get('column_products');
		$data['column_categories'] = $this->language->get('column_categories');
		$data['column_logged'] = $this->language->get('column_logged');
		$data['column_shipping'] = $this->language->get('column_shipping');
		$data['column_discount'] = $this->language->get('column_discount');
		$data['column_date_start'] = $this->language->get('column_date_start');
		$data['column_date_end'] = $this->language->get('column_date_end');
		$data['column_uses_total'] = $this->language->get('column_uses_total');
		$data['column_uses_customer'] = $this->language->get('column_uses_customer');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

		$data['error_ajax_request'] = $this->language->get('error_ajax_request');
		$data['error_update'] = $this->language->get('error_update');
		$data['error_load_popup'] = $this->language->get('error_load_popup');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_close'] = $this->language->get('button_close');
		$data['button_save'] = $this->language->get('button_save');

		$data['aqe_tooltip'] = ($this->config->get('aqe_quick_edit_on') == 'dblclick') ? $this->language->get('text_double_click_edit') : $this->language->get('text_click_edit');
		$data['aqe_quick_edit_on'] = $this->config->get('aqe_quick_edit_on');
		$data['aqe_row_hover_highlighting'] = $this->config->get('aqe_row_hover_highlighting');
		$data['aqe_alternate_row_colour'] = $this->config->get('aqe_alternate_row_colour');

		$this->document->addScript('view/javascript/aqe/catalog.min.js');

		$this->document->addStyle('view/stylesheet/aqe/css/catalog.min.css');

		$filters = array();

		foreach($this->config->get('aqe_marketing_coupons') as $column => $attr) {
			$filters[$column] = (isset($this->request->get['filter_' . $column])) ? $this->request->get['filter_' . $column] : null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'c.name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		foreach($this->config->get('aqe_marketing_coupons') as $column => $attr) {
			if (isset($this->request->get['filter_' . $column])) {
				$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
			}
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

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
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('marketing/coupon', 'token=' . $this->session->data['token'] . $url, true),
			'active'    => true
		);

		$data['add'] = $this->url->link('marketing/coupon/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('marketing/coupon/delete', 'token=' . $this->session->data['token'] . $url, true);

		$actions = array(
			'product'           => array('display' => 1, 'index' =>  1, 'short' => 'prod',    'type' =>   'products_qe', 'class' => 'btn-default', 'icon' => '',       'rel' => array('products')),
			'category'          => array('display' => 1, 'index' =>  2, 'short' =>  'cat',    'type' => 'categories_qe', 'class' => 'btn-default', 'icon' => '',       'rel' => array('categories')),
			'edit'              => array('display' => 1, 'index' =>  3, 'short' =>   'ed',    'type' =>          'edit', 'class' => 'btn-primary', 'icon' => 'pencil', 'rel' => array()),
		);

		$actions = array_filter($actions, 'column_display');
		foreach ($actions as $action => $attr) {
			$actions[$action]['name'] = $this->language->get('action_' . $action);
		}
		uasort($actions, 'column_sort');
		$data['coupon_actions'] = $actions;

		$columns = $this->config->get('aqe_marketing_coupons');
		$columns = array_filter($columns, 'column_display');
		foreach ($columns as $column => $attr) {
			$columns[$column]['name'] = $this->language->get('column_' . $column);
		}
		uasort($columns, 'column_sort');
		$data['coupon_columns'] = $columns;

		$displayed_columns = array_keys($columns);
		$displayed_actions = array_keys($actions);
		$related_columns = array_merge(array_map(function($v) { return isset($v['rel']) ? $v['rel'] : ''; }, $columns), array_map(function($v) { return isset($v['rel']) ? $v['rel'] : ''; }, $actions));

		$data['coupons'] = array();

		$filter_data = array(
			'sort'      => $sort,
			'order'     => $order,
			'start'     => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'     => $this->config->get('config_limit_admin'),
			'columns'   => $displayed_columns,
			'actions'   => $displayed_actions
		);

		foreach ($filters as $filter => $value) {
			$filter_data['filter_' . $filter] = $value;
		}

		$results = $this->model_marketing_aqe_coupon->getCoupons($filter_data);

		$coupon_total = $this->model_marketing_aqe_coupon->getTotalCoupons();

		foreach ($results as $result) {
			$_buttons = array();

			foreach ($actions as $action => $attr) {
				switch ($action) {
					case 'edit':
						$_buttons[] = array(
							'type'  => $attr['type'],
							'action'=> $action,
							'title' => $this->language->get('action_' . $action),
							'url'   => html_entity_decode($this->url->link('marketing/coupon/edit', '&coupon_id=' . $result['coupon_id'] . '&token=' . $this->session->data['token'] . $url, true), ENT_QUOTES, 'UTF-8'),
							'icon'  => $attr['icon'],
							'name'  => null,
							'rel'   => json_encode($attr['rel']),
							'class' => $attr['class'],
						);
						break;
					default:
						$_buttons[] = array(
							'type'  => $attr['type'],
							'action'=> $action,
							'title' => $this->language->get('action_' . $action),
							'url'   => null,
							'icon'  => $attr['icon'],
							'name'  => $this->language->get('action_' . $attr['short']),
							'rel'   => json_encode($attr['rel']),
							'class' => $attr['class'],
						);
						break;
				}
			}

			$row = array(
				'coupon_id'  => $result['coupon_id'],
				'selected'   => isset($this->request->post['selected']) && in_array($result['coupon_id'], $this->request->post['selected']),
				'action'     => $_buttons
			);
			if (!is_array($columns)) {
				$row['name'] = $result['name'];
				$row['code'] = $result['code'];
				$row['discount'] = $result['discount'];
				$row['date_start'] = $result['date_start'];
				$row['date_end'] = $result['date_end'];
				$row['status'] = $result['status'];
			} else {
				foreach ($columns as $column => $attr) {
					if (in_array($column, array('logged', 'shipping'))) {
						$row[$column] = ($result[$column] ? $this->language->get('text_yes') : $this->language->get('text_no'));
					} else if ($column == 'status') {
						if ((int)$result['status'] || !$this->config->get('aqe_highlight_status')) {
							$row[$column] = ((int)$result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'));
						} else {
							$row[$column] = ((int)$result['status'] ? $this->language->get('text_enabled') : '<span style="color:#FF0000;">' . $this->language->get('text_disabled') . '</span>');
						}
					} else if ($column == 'id') {
						$row[$column] = $result['coupon_id'];
					} else if (in_array($column, array('date_start', 'date_end'))) {
						$date = new DateTime($result[$column]);
						$row[$column] = $date->format("Y-m-d");
					} else if ($column == 'type') {
						$row[$column] = $result[$column] == 'P' ? $this->language->get('text_percent') : $this->language->get('text_amount');
					} else if ($column == 'action') {
						$row[$column] = $_buttons;
					} else if ($column == 'selector') {
						$row[$column] = '';
					} else if ($column == 'products') {
						$products = $this->model_marketing_aqe_coupon->getCouponProducts($result['coupon_id']);
						$row[$column] = implode("<br />", $products);
					} else if ($column == 'categories') {
						$this->load->model('catalog/category');
						$categories = $this->model_marketing_coupon->getCouponCategories($result['coupon_id']);
						$category_paths = array();
						foreach($categories as $cat) {
							$category = $this->model_catalog_category->getCategory($cat);
							$category_paths[] = (($category['path']) ? $category['path'] . ' &gt; ' : '') . $category['name'];
						}
						$row[$column] = implode("<br />", $category_paths);
					} else {
						$row[$column] = $result[$column];
					}
				}
			}
			$data['coupons'][] = $row;
		}

		$data['language_id'] = $this->config->get('config_language_id');

		$column_classes = array();
		$type_classes = array();
		$non_sortable = array();

		if (!is_array($columns)) {
			$displayed_columns = array('selector', 'name', 'code', 'discount', 'date_start', 'date_end', 'status', 'action');
			$columns = array();
		} else {
			foreach ($columns as $column => $attr) {
				if (empty($attr['sort'])) {
					$non_sortable[] = 'col_' . $column;
				}

				if (!empty($attr['type']) && !in_array($attr['type'], $type_classes)) {
					$type_classes[] = $attr['type'];
				}

				if (!empty($attr['align'])) {
					if (!empty($attr['type']) && $attr['editable']) {
						$column_classes[] = $attr['align'] . ' ' . $attr['type'];
					} else {
						$column_classes[] = $attr['align'];
					}
				} else {
					if (!empty($attr['type'])) {
						$column_classes[] = $attr['type'];
					} else {
						$column_classes[] = null;
					}
				}
			}
		}

		$data['columns'] = $displayed_columns;
		$data['actions'] = $displayed_actions;
		$data['related'] = $related_columns;
		$data['column_info'] = $columns;
		$data['non_sortable_columns'] = json_enc($non_sortable);
		$data['column_classes'] = $column_classes;
		$data['types'] = $type_classes;

		$data['update_url'] = html_entity_decode($this->url->link('marketing/coupon/quick_update', 'token=' . $this->session->data['token'], true));
		$data['load_popup_url'] = html_entity_decode($this->url->link('marketing/coupon/load_popup', 'token=' . $this->session->data['token'], true));
		$data['refresh_url'] = html_entity_decode($this->url->link('marketing/coupon/refresh_data', 'token=' . $this->session->data['token'], true));

		$data['yes_no_select'] = addslashes(json_encode(array(array("id" => "0", "value" => $this->language->get('text_no')), array("id" => "1", "value" => $this->language->get('text_yes')))));
		$data['status_select'] = addslashes(json_encode(array(array("id" => "0", "value" => $this->language->get('text_disabled')), array("id" => "1", "value" => $this->language->get('text_enabled')))));
		$data['type_select'] = addslashes(json_encode(array(array("id" => "P", "value" => $this->language->get('text_percent')), array("id" => "F", "value" => $this->language->get('text_amount')))));

		$data['batch_edit'] = (int)$this->config->get('aqe_batch_edit');

		$data['token'] = $this->session->data['token'];

		$url = '';

		foreach ($this->config->get('aqe_marketing_coupons') as $column => $attr) {
			if (isset($this->request->get['filter_' . $column])) {
				$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
			}
		}
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sorts'] = array();
		foreach ($this->config->get('aqe_marketing_coupons') as $column => $attr) {
			$data['sorts'][$column] = $this->url->link('marketing/coupon', 'token=' . $this->session->data['token'] . '&sort=' . $attr['sort'] . $url, true);
		}

		$url = '';

		foreach ($this->config->get('aqe_marketing_coupons') as $column => $attr) {
			if (isset($this->request->get['filter_' . $column])) {
				$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
			}
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $coupon_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('marketing/coupon', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($coupon_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($coupon_total - $this->config->get('config_limit_admin'))) ? $coupon_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $coupon_total, ceil($coupon_total / $this->config->get('config_limit_admin')));

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

		$data['filters'] = $filters;
		$data['alerts'] = $this->alert;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		if (version_compare(VERSION, '2.2.0', '>=')) {
			$template = 'marketing/aqe/coupon_list';
		} else {
			$template = 'marketing/aqe/coupon_list.tpl';
		}

		$this->response->setOutput($this->load->view($template, $data));
	}

	public function load_popup() {
		$response = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateLoadPopup($this->request->post)) {
			$data['error_warning'] = '';
			list($data['parameter'], $data['i_id']) = explode("-", $this->request->post['id']);

			$data['token'] = $this->session->data['token'];

			$response["success"] = 1;

			switch ($data['parameter']) {
				case 'product':
				case 'products':
					$data['text_autocomplete'] = $this->language->get('text_autocomplete');
					$data['autocomplete'] = html_entity_decode($this->url->link('catalog/product/autocomplete', 'token=' . $this->session->data['token'] . '&filter_name=', true));
					$data['item_label'] = 'name';
					$data['item_value'] = 'product_id';
					$items = array();
					$products = $this->model_marketing_aqe_coupon->getCouponProducts($data['i_id']);
					foreach ($products as $product_id => $name) {
						$items[] = array("id" => $product_id, "name" => $name);
					}
					$data['items'] = $items;
					break;
				case 'category':
				case 'categories':
					$this->load->model('catalog/category');

					$data['text_autocomplete'] = $this->language->get('text_autocomplete');
					$data['autocomplete'] = html_entity_decode($this->url->link('catalog/category/autocomplete', 'token=' . $this->session->data['token'] . '&filter_name=', true));
					$data['item_label'] = 'name';
					$data['item_value'] = 'category_id';
					$items = array();
					$categories = $this->model_marketing_coupon->getCouponCategories($data['i_id']);
					foreach ($categories as $category_id) {
						$category_info = $this->model_catalog_category->getCategory($category_id);

						if ($category_info) {
							$items[] = array("id" => $category_id, "name" => ($category_info['path'] ? $category_info['path'] . ' &gt; ' : '') . $category_info['name']);
						}
					}
					$data['items'] = $items;
					break;
				default:
					$response["success"] = 0;
					// $response['error'] = $this->language->get('error_load_popup');
					$this->alert['error']['load'] = $this->language->get('error_load_popup');
					break;
			}
			$response['title'] = $this->language->get('action_' . $data['parameter']);
		} else {
			$this->alert['error']['load'] = $this->language->get('error_load_popup');
		}

		if (version_compare(VERSION, '2.2.0', '>=')) {
			$template = 'marketing/aqe/quick_edit_form';
		} else {
			$template = 'marketing/aqe/quick_edit_form.tpl';
		}

		$response['popup'] = $this->load->view($template, $data);

		$response = array_merge($response, array("errors" => $this->error), array("alerts" => $this->alert));

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($response));
	}

	public function refresh_data() {
		$response = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateRefreshData($this->request->post)) {
			$response['values'] = array();

			foreach ($this->request->post['data'] as $column => $coupons) {
				foreach ($coupons as $id) {
					switch ($column) {
						case 'products':
							$products = $this->model_marketing_aqe_coupon->getCouponProducts($id);
							$response['values'][$id][$column] = implode("<br />", $products);
							break;
						case 'categories':
							$this->load->model('catalog/category');
							$categories = $this->model_marketing_coupon->getCouponCategories($id);
							$category_paths = array();
							foreach($categories as $cat) {
								$category = $this->model_catalog_category->getCategory($cat);
								$category_paths[] = (($category['path']) ? $category['path'] . ' &gt; ' : '') . $category['name'];
							}
							$response['values'][$id][$column] = implode("<br />", $category_paths);
							break;
						default:
							$response['value'] = "";
							break;
					}
				}
			}
			$response['success'] = 1;
		}

		$response = array_merge($response, array("errors" => $this->error), array("alerts" => $this->alert));

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($response));
	}

	public function quick_update() {
		$response = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateUpdateData($this->request->post)) {
			list($column, $id) = explode("-", $this->request->post['id']);
			$id = (array)$id;
			$value = $this->request->post['new'];
			$lang_id = isset($this->request->post['lang_id']) ? $this->request->post['lang_id'] : null;

			if (isset($this->request->post['ids'])) {
				$id = array_unique(array_merge($id, (array)$this->request->post['ids']));
			}

			$results = array('done' => array(), 'failed' => array());

			foreach ((array)$id as $_id) {
				if ($this->model_marketing_aqe_coupon->quickEditCoupon($_id, $column, $value, $lang_id, $this->request->post)) {
					$results['done'][] = $_id;
				} else {
					$results['failed'][] = $_id;
				}
			}

			$response['results'] = $results;

			if ($results['done']) {
				$this->alert['success']['update'] = $this->language->get('text_success');
				$response['success'] = 1;

				if (in_array($column, array('product', 'category'))) {
					$response['value'] = '';
					$response['values']['*'] = $response['value'];
				} else if (in_array($column, array('logged', 'shipping'))) {
					$response['value'] = ((int)$value) ? $this->language->get('text_yes') : $this->language->get('text_no');
					$response['values']['*'] = $response['value'];
				} else if (in_array($column, array('type'))) {
					$response['value'] = ($value == 'P') ? $this->language->get('text_percent') : $this->language->get('text_amount');
					$response['values']['*'] = $response['value'];
				} else if ($column == 'status') {
					if ((int)$value || !$this->config->get('aqe_highlight_status')) {
						$response['value'] = ((int)$value) ? $this->language->get('text_enabled') : $this->language->get('text_disabled');
					} else {
						$response['value'] = ((int)$value) ? $this->language->get('text_enabled') : '<span style="color:#FF0000;">' . $this->language->get('text_disabled') . '</span>';
					}
					$response['values']['*'] = $response['value'];
				} else if (in_array($column, array('uses_total', 'uses_customer'))) {
					$response['value'] = (int)$value;
					$response['values']['*'] = $response['value'];
				} else if (in_array($column, array('total', 'discount'))) {
					$response['value'] = (float)$value;
					$response['values']['*'] = $response['value'];
				} else if (in_array($column, array('product', 'products'))) {
					$products = $this->model_marketing_aqe_coupon->getCouponProducts($id[0]);
					if ($products)
						$response['value'] = implode('<br/>', $products);
					else
						$response['value'] = '';
					$response['values']['*'] = $response['value'];
				} else if (in_array($column, array('category', 'categories'))) {
					$this->load->model('catalog/category');
					$categories = $this->model_marketing_coupon->getCouponCategories($id[0]);
					$category_paths = array();
					foreach($categories as $cat) {
						$category = $this->model_catalog_category->getCategory($cat);
						$category_paths[] = (($category['path']) ? $category['path'] . ' &gt; ' : '') . $category['name'];
					}

					if ($category_paths)
						$response['value'] = implode('<br/>', $category_paths);
					else
						$response['value'] = '';
					$response['values']['*'] = $response['value'];
				} else {
					$response['value'] = $value;
					$response['values']['*'] = $response['value'];
				}
			} else {
				$this->alert['error']['result'] = $this->language->get('error_update');
			}
		}

		$response = array_merge($response, array("errors" => $this->error), array("alerts" => $this->alert));

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($response));
	}

	protected function validateDelete() {
		return $this->validatePermissions();
	}

	protected function validateLoadPopup(&$data) {
		$errors = !$this->validatePermissions();

		if (!isset($data['id']) || strpos($data['id'], "-") === false) {
			$errors = true;
			$this->alert['error']['request'] = $this->language->get('error_update');
		}

		return !$errors;
	}

	protected function validateUpdateData(&$data) {
		$errors = !$this->validatePermissions();

		if (!isset($data['id']) || strpos($data['id'], "-") === false) {
			$errors = true;
			$this->alert['error']['request'] = $this->language->get('error_update');
			return false;
		}

		list($column, $id) = explode("-", $data['id']);

		if (!isset($data['old'])) {
			$errors = true;
			$this->alert['error']['request'] = $this->language->get('error_update');
		}

		if (!isset($data['new'])) {
			$errors = true;
			$this->alert['error']['request'] = $this->language->get('error_update');
		}

		if ($column == "name" && ((utf8_strlen(trim($data['new'])) < 3) || utf8_strlen(trim($data['new'])) > 128)) {
			$errors = true;
			$this->alert['error']['name'] = $this->language->get('error_name');
		}

		if ($column == "code") {
			$coupon_info = $this->model_marketing_coupon->getCouponByCode($data['new']);

			if (isset($data['ids']) && count((array)$data['ids']) > 1) {
				$errors = true;
				$this->alert['error']['request'] = $this->language->get('error_batch_edit_code');
			} else if (utf8_strlen(trim($data['new'])) < 3 || utf8_strlen(trim($data['new'])) > 10) {
				$errors = true;
				$this->alert['error']['code'] = $this->language->get('error_code');
			} else if ($coupon_info && $coupon_info['coupon_id'] != $id) {
				$errors = true;
				$this->alert['error']['code'] = $this->language->get('error_exists');
			}
		}

		if ($this->error && !isset($this->alert['warning']['warning'])) {
			$this->alert['warning']['warning'] = $this->language->get('error_warning');
		}

		return !$errors;
	}

	protected function validateRefreshData(&$data) {
		$errors = !$this->validatePermissions();

		if (!isset($data['data'])) {
			$errors = true;
			$this->alert['error']['request'] = $this->language->get('error_update');
			return false;
		}

		return !$errors;
	}

	private function validatePermissions() {
		if (!$this->user->hasPermission('modify', 'marketing/coupon')) {
			$this->alert['error']['permission'] = $this->language->get('error_permission');
			return false;
		} else {
			return true;
		}
	}
}
