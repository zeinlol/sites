<?php
class ControllerSaleAqeReturn extends Controller {
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

		$this->load->model('sale/return');
		$this->load->model('sale/aqe/return');

		$this->load->language('sale/return');
		$this->load->language('sale/aqe/general');
		$this->load->language('sale/aqe/return');

		if (!$this->config->get('aqe_installed') || !$this->config->get('aqe_status')) {
			$this->response->redirect($this->url->link('sale/return', 'token=' . $this->session->data['token'], true));
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
				$this->model_sale_return->deleteReturn($item_id);
			}

			$this->session->data['success'] = sprintf($this->language->get('text_success_delete'), count($this->request->post['selected']));

			$url = '';

			foreach($this->config->get('aqe_sales_returns') as $column => $attr) {
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

			$this->response->redirect($this->url->link('sale/return', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_opened'] = $this->language->get('text_opened');
		$data['text_unopened'] = $this->language->get('text_unopened');
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
		$data['text_notify_customer'] = $this->language->get('text_notify_customer');

		$data['column_id'] = $this->language->get('column_id');
		$data['column_order_id'] = $this->language->get('column_order_id');
		$data['column_customer_id'] = $this->language->get('column_customer_id');
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_email'] = $this->language->get('column_email');
		$data['column_telephone'] = $this->language->get('column_telephone');
		$data['column_product_id'] = $this->language->get('column_product_id');
		$data['column_product'] = $this->language->get('column_product');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_return_reason'] = $this->language->get('column_return_reason');
		$data['column_opened'] = $this->language->get('column_opened');
		$data['column_comment'] = $this->language->get('column_comment');
		$data['column_return_action'] = $this->language->get('column_return_action');
		$data['column_return_status'] = $this->language->get('column_return_status');
		$data['column_date_ordered'] = $this->language->get('column_date_ordered');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_date_modified'] = $this->language->get('column_date_modified');
		$data['column_action'] = $this->language->get('column_action');

		$data['error_ajax_request'] = $this->language->get('error_ajax_request');
		$data['error_update'] = $this->language->get('error_update');
		$data['error_load_popup'] = $this->language->get('error_load_popup');

		$data['button_ok'] = $this->language->get('button_ok');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_close'] = $this->language->get('button_close');
		$data['button_save'] = $this->language->get('button_save');

		$data['aqe_tooltip'] = ($this->config->get('aqe_quick_edit_on') == 'dblclick') ? $this->language->get('text_double_click_edit') : $this->language->get('text_click_edit');
		$data['aqe_quick_edit_on'] = $this->config->get('aqe_quick_edit_on');
		$data['notify_customer'] = $this->config->get('aqe_sales_returns_notify_customer');
		$data['aqe_row_hover_highlighting'] = $this->config->get('aqe_row_hover_highlighting');
		$data['aqe_alternate_row_colour'] = $this->config->get('aqe_alternate_row_colour');

		$this->document->addScript('view/javascript/aqe/catalog.min.js');

		$this->document->addStyle('view/stylesheet/aqe/css/catalog.min.css');

		$filters = array();

		foreach($this->config->get('aqe_sales_returns') as $column => $attr) {
			$filters[$column] = (isset($this->request->get['filter_' . $column])) ? $this->request->get['filter_' . $column] : null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'r.return_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		foreach($this->config->get('aqe_sales_returns') as $column => $attr) {
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
			'href'      => $this->url->link('sale/return', 'token=' . $this->session->data['token'] . $url, true),
			'active'    => true
		);

		$data['add'] = $this->url->link('sale/return/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('sale/return/delete', 'token=' . $this->session->data['token'] . $url, true);

		$actions = array(
			'edit'              => array('display' => 1, 'index' =>  4, 'short' => 'ed',    'type' =>       'edit', 'class' => 'btn-primary', 'rel' => array()),
		);

		$actions = array_filter($actions, 'column_display');
		foreach ($actions as $action => $attr) {
			$actions[$action]['name'] = $this->language->get('action_' . $action);
		}
		uasort($actions, 'column_sort');
		$data['return_actions'] = $actions;

		$columns = $this->config->get('aqe_sales_returns');
		$columns = array_filter($columns, 'column_display');
		foreach ($columns as $column => $attr) {
			$columns[$column]['name'] = $this->language->get('column_' . $column);

			if ($column == 'view_in_store' && !$multistore) {
				unset($columns[$column]);
			}
		}
		uasort($columns, 'column_sort');
		$data['return_columns'] = $columns;

		$displayed_columns = array_keys($columns);
		$displayed_actions = array_keys($actions);
		$related_columns = array_merge(array_map(function($v) { return isset($v['rel']) ? $v['rel'] : ''; }, $columns), array_map(function($v) { return isset($v['rel']) ? $v['rel'] : ''; }, $actions));

		$data['returns'] = array();

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

		$this->load->model('tool/image');

		$results = $this->model_sale_aqe_return->getReturns($filter_data);

		$return_total = $this->model_sale_aqe_return->getTotalReturns();

		foreach ($results as $result) {
			$_buttons = array();

			foreach ($actions as $action => $attr) {
				switch ($action) {
					case 'edit':
						$_buttons[] = array(
							'type'  => $attr['type'],
							'action'=> $action,
							'title' => $this->language->get('action_' . $action),
							'url'   => html_entity_decode($this->url->link('sale/return/edit', '&return_id=' . $result['return_id'] . '&token=' . $this->session->data['token'] . $url, true), ENT_QUOTES, 'UTF-8'),
							'icon'  => 'pencil',
							'name'  => null,
							'rel'   => json_encode(array()),
							'class' => $attr['class'],
						);
						break;
					default:
						$_buttons[] = array(
							'type'  => $attr['type'],
							'action'=> $action,
							'title' => $this->language->get('action_' . $action),
							'url'   => null,
							'icon'  => null,
							'name'  => $this->language->get('action_' . $attr['short']),
							'rel'   => json_encode($attr['rel']),
							'class' => $attr['class'],
						);
						break;
				}
			}

			$row = array(
				'return_id'  => $result['return_id'],
				'selected'   => isset($this->request->post['selected']) && in_array($result['return_id'], $this->request->post['selected']),
				'action'     => $_buttons
			);
			if (!is_array($columns)) {
				$row['order_id'] = $result['order_id'];
				$row['customer'] = $result['customer'];
				$row['product'] = $result['product'];
				$row['model'] = $result['model'];
				$row['return_status'] = $result['return_status'];
				$row['date_added'] = $result['date_added'];
				$row['date_modified'] = $result['date_modified'];
			} else {
				foreach ($columns as $column => $attr) {
					if ($column == 'opened') {
						$row[$column] = ($result['opened'] ? $this->language->get('text_opened') : $this->language->get('text_unopened'));
					// } else if ($column == 'return_status') {
					// 	if ((int)$result['status'] || !$this->config->get('aqe_highlight_status')) {
					// 		$row[$column] = ((int)$result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'));
					// 	} else {
					// 		$row[$column] = ((int)$result['status'] ? $this->language->get('text_enabled') : '<span style="color:#FF0000;">' . $this->language->get('text_disabled') . '</span>');
					// 	}
					} else if ($column == 'id') {
						$row[$column] = $result['return_id'];
					} else if (in_array($column, array('date_added', 'date_ordered', 'date_modified'))) {
						$date = new DateTime($result[$column]);
						$row[$column] = $date->format("Y-m-d");
					} else if ($column == 'product_id') {
						// $row[$column] = $result[$column];
						$row[$column] = $result['product_name'];
						$row['product_href'] = $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'], true);
					} else if ($column == 'customer_id') {
						// $row[$column] = $result[$column];
						$row[$column] = $result['customer_name'];
						if (version_compare(VERSION, '2.1.0') < 0) {
							$row['product_href'] = $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $result['customer_id'], true);
						} else {
							$row['product_href'] = $this->url->link('customer/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $result['customer_id'], true);
						}
					} else if ($column == 'action') {
						$row[$column] = $_buttons;
					} else if ($column == 'selector') {
						$row[$column] = '';
					} else {
						$row[$column] = $result[$column];
					}
				}
			}
			$data['returns'][] = $row;
		}

		$data['language_id'] = $this->config->get('config_language_id');

		$column_classes = array();
		$type_classes = array();
		$non_sortable = array();

		if (!is_array($columns)) {
			$displayed_columns = array('selector', 'return_id', 'order_id', 'customer', 'product', 'model', 'return_status', 'date_added', 'date_modified', 'action');
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

		$data['update_url'] = html_entity_decode($this->url->link('sale/return/quick_update', 'token=' . $this->session->data['token'], true));
		$data['refresh_url'] = html_entity_decode($this->url->link('sale/return/refresh_data', 'token=' . $this->session->data['token'], true));
		$data['yes_no_select'] = addslashes(json_encode(array(array("id" => "0", "value" => $this->language->get('text_unopened')), array("id" => "1", "value" => $this->language->get('text_opened')))));

		$data['load_popup_url'] = html_entity_decode($this->url->link('sale/return/load_popup', 'token=' . $this->session->data['token'], true));

		// $this->load->model('localisation/language');
		// $lang_count = $this->model_localisation_language->getTotalLanguages();
		// $data['single_lang_editing'] = $this->config->get('aqe_single_language_editing') || ((int)$lang_count == 1);
		$data['batch_edit'] = (int)$this->config->get('aqe_batch_edit');

		if (in_array("return_reason", $displayed_columns)) {
			$this->load->model('localisation/return_reason');
			$data['return_reasons'] = $this->model_localisation_return_reason->getReturnReasons();
			$rr_select = array();
			foreach ($data['return_reasons'] as $rr) {
				$rr_select[] = array("id" => $rr['return_reason_id'], "value" => $rr['name']);
			}
			$data['return_reasons_select'] = addslashes(json_enc($rr_select, JSON_UNESCAPED_SLASHES));
		} else {
			$data['return_reasons_select'] = addslashes(json_encode(array()));
		}

		if (in_array("return_action", $displayed_columns)) {
			$this->load->model('localisation/return_action');
			$data['return_actions'] = $this->model_localisation_return_action->getReturnActions();
			$ra_select = array(array("id" => "0", "value" => ""));
			foreach ($data['return_actions'] as $ra) {
				$ra_select[] = array("id" => $ra['return_action_id'], "value" => $ra['name']);
			}
			$data['return_actions_select'] = addslashes(json_enc($ra_select, JSON_UNESCAPED_SLASHES));
		} else {
			$data['return_actions_select'] = addslashes(json_encode(array()));
		}

		if (in_array("return_status", $displayed_columns)) {
			$this->load->model('localisation/return_status');
			$data['return_statuses'] = $this->model_localisation_return_status->getReturnStatuses();
			$rs_select = array();
			foreach ($data['return_statuses'] as $rs) {
				$rs_select[$rs['return_status_id']] = $rs['name'];
			}
			$data['return_statuses_select'] = addslashes(json_enc($rs_select, JSON_UNESCAPED_SLASHES));
		} else {
			$data['return_statuses_select'] = addslashes(json_encode(array()));
		}

		$data['token'] = $this->session->data['token'];

		$url = '';

		foreach ($this->config->get('aqe_sales_returns') as $column => $attr) {
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
		foreach ($this->config->get('aqe_sales_returns') as $column => $attr) {
			$data['sorts'][$column] = $this->url->link('sale/return', 'token=' . $this->session->data['token'] . '&sort=' . $attr['sort'] . $url, true);
		}

		$url = '';

		foreach ($this->config->get('aqe_sales_returns') as $column => $attr) {
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
		$pagination->total = $return_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('sale/return', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($return_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($return_total - $this->config->get('config_limit_admin'))) ? $return_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $return_total, ceil($return_total / $this->config->get('config_limit_admin')));

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
			$template = 'sale/aqe/return_list';
		} else {
			$template = 'sale/aqe/return_list.tpl';
		}

		$this->response->setOutput($this->load->view($template, $data));
	}

	public function autocomplete() {
		$response = array();

		if (isset($this->request->get['filter_product']) || isset($this->request->get['filter_product_id'])) {
			$this->load->model('catalog/product_ext');

			$filter_types = array('product', 'product_id');
			$filters = array();

			foreach ($filter_types as $filter) {
				if (isset($this->request->get['filter_' . $filter])) {
					$filters['name'] = $this->request->get['filter_' . $filter];
				}
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 20;
			}

			$filter_data = array(
				'start'               => 0,
				'limit'               => $limit,
				'columns'             => $filter_types
			);

			foreach($filters as $filter => $value) {
				$filter_data['filter_' . $filter] = $value;
			}

			$results = $this->model_catalog_product_ext->getProducts($filter_data);

			foreach ($results as $result) {
				$response[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
				);
			}
		} else if (isset($this->request->get['filter_customer']) || isset($this->request->get['filter_customer_id'])) {
			if (version_compare(VERSION, '2.1.0') < 0) {
				$this->load->model('sale/customer');
			} else {
				$this->load->model('customer/customer');
			}

			$filter_types = array('customer', 'customer_id');
			$filters = array();

			foreach ($filter_types as $filter) {
				if (isset($this->request->get['filter_' . $filter])) {
					$filters['name'] = $this->request->get['filter_' . $filter];
				}
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 20;
			}

			$filter_data = array(
				'start'               => 0,
				'limit'               => $limit,
				'columns'             => $filter_types
			);

			foreach($filters as $filter => $value) {
				$filter_data['filter_' . $filter] = $value;
			}

			if (version_compare(VERSION, '2.1.0') < 0) {
				$results = $this->model_sale_customer->getCustomers($filter_data);
			} else {
				$results = $this->model_customer_customer->getCustomers($filter_data);
			}

			$response[] = array(
				'customer_id'=> '0',
				'first_name' => '',
				'last_name'  => '',
				'full_name'  => strip_tags(html_entity_decode($this->language->get('text_none'), ENT_QUOTES, 'UTF-8')),
			);
			foreach ($results as $result) {
				$response[] = array(
					'customer_id'=> $result['customer_id'],
					'first_name' => $result['firstname'],
					'last_name'  => $result['lastname'],
					'full_name'  => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($response));
	}

	public function load_popup() {
		$response = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateLoadPopup($this->request->post)) {
			$data['error_warning'] = '';
			list($data['parameter'], $data['i_id']) = explode("-", $this->request->post['id']);

			$data['token'] = $this->session->data['token'];

			$response["success"] = 1;

			switch ($data['parameter']) {
				case "customer":
					$data['text_first_name'] = $this->language->get('text_first_name');
					$data['text_last_name'] = $this->language->get('text_last_name');

					$return = $this->model_sale_return->getReturn($data['i_id']);
					$data['first_name'] = $return['firstname'];
					$data['last_name'] = $return['lastname'];
					// $data['customer_id'] = $return['customer_id'];
					break;
				default:
					$response["success"] = 0;
					$response['error'] = $this->language->get('error_load_popup');
					break;
			}
			$response['title'] = $this->language->get('action_' . $data['parameter']);
		} else {
			$this->alert['error']['load'] = $this->language->get('error_load_popup');
		}

		if (version_compare(VERSION, '2.2.0', '>=')) {
			$template = 'sale/aqe/quick_edit_form';
		} else {
			$template = 'sale/aqe/quick_edit_form.tpl';
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

			foreach ($this->request->post['data'] as $column => $returns) {
				foreach ($returns as $id) {
					switch ($column) {
						case 'date_modified':
							$result = $this->model_sale_return->getReturn($id);
							$date = new DateTime($result[$column]);
							$response['values'][$id][$column] = $date->format("Y-m-d");
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
			$alt = isset($this->request->post['alt']) ? $this->request->post['alt'] : "";

			if (isset($this->request->post['ids'])) {
				$id = array_unique(array_merge($id, (array)$this->request->post['ids']));
			}

			$results = array('done' => array(), 'failed' => array());

			if ($column == 'return_status') {
				if (isset($this->request->post['notify'])) {
					$notify = $this->request->post['notify'];
				} else {
					$notify = $this->config->get('aqe_sales_returns_notify_customer');
				}

				$data = array();
				$data['notify'] = $notify;
				$data['comment'] = isset($this->request->post['comment']) ? $this->request->post['comment'] : '';
				$data['return_status_id'] = $value;

				foreach ($id as $_id) {
					$this->model_sale_return->addReturnHistory($_id, $data);
					$results['done'][] = $_id;
				}
			} else {
				foreach ((array)$id as $_id) {
					if ($this->model_sale_aqe_return->quickEditReturn($_id, $column, $value, $lang_id, $this->request->post)) {
						$results['done'][] = $_id;
					} else {
						$results['failed'][] = $_id;
					}
				}
			}

			$response['results'] = $results;

			if ($results['done']) {
				$this->alert['success']['update'] = $this->language->get('text_success');
				$response['success'] = 1;

				if (in_array($column, array('email', 'telephone', 'product', 'model', 'comment', 'date_ordered'))) {
					$response['value'] = $value;
					$response['values']['*'] = $response['value'];
				} else if (in_array($column, array('return_id', 'order_id', 'quantity'))) {
					$response['value'] = (int)$value;
					$response['values']['*'] = $response['value'];
				} else if (in_array($column, array('opened'))) {
					$response['value'] = ((int)$value) ? $this->language->get('text_opened') : $this->language->get('text_unopened');
					$response['values']['*'] = $response['value'];
				} else if ($column == 'return_reason') {
					$this->load->model('localisation/return_reason');
					$return_reason = $this->model_localisation_return_reason->getReturnReason((int)$value);
					if ($return_reason)
						$response['value'] = $return_reason['name'];
					else
						$response['value'] = '';
					$response['values']['*'] = $response['value'];
				} else if ($column == 'return_action') {
					$this->load->model('localisation/return_action');
					$return_action = $this->model_localisation_return_action->getReturnAction((int)$value);
					if ($return_action)
						$response['value'] = $return_action['name'];
					else
						$response['value'] = '';
					$response['values']['*'] = $response['value'];
				} else if ($column == 'return_status') {
					$this->load->model('localisation/return_status');
					$return_status = $this->model_localisation_return_status->getReturnStatus((int)$value);
					if ($return_status)
						$response['value'] = $return_status['name'];
					else
						$response['value'] = '';
					$response['values']['*'] = $response['value'];
				} else if ($column == 'product_id') {
					$this->load->model('catalog/product');
					$product = $this->model_catalog_product->getProduct((int)$value);
					if ($product)
						$response['value'] = $product['name'];
					else
						$response['value'] = '';
					$response['values']['*'] = $response['value'];
				} else if ($column == 'customer_id') {
					if (version_compare(VERSION, '2.1.0') < 0) {
						$this->load->model('sale/customer');
						$customer = $this->model_sale_customer->getCustomer((int)$value);
					} else {
						$this->load->model('customer/customer');
						$customer = $this->model_customer_customer->getCustomer((int)$value);
					}
					if ($customer)
						$response['value'] = $customer['firstname'] . ' ' . $customer['lastname'];
					else
						$response['value'] = '';
					$response['values']['*'] = $response['value'];
				} else if ($column == 'customer') {
					$response['value'] = $this->request->post['first_name'] . ' ' . $this->request->post['last_name'];
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

		if ($column == "customer") {
			if ((utf8_strlen(trim($data['first_name'])) < 1) || (utf8_strlen(trim($data['first_name'])) > 32)) {
				$errors = true;
				// $this->alert['error']['first_name'] = $this->language->get('error_firstname');
				$this->error['first_name'] = $this->language->get('error_firstname');
			}
			if ((utf8_strlen(trim($data['last_name'])) < 1) || (utf8_strlen(trim($data['last_name'])) > 32)) {
				$errors = true;
				// $this->alert['error']['last_name'] = $this->language->get('error_lastname');
				$this->error['last_name'] = $this->language->get('error_lastname');
			}
		}

		if ($column == "email" && ((utf8_strlen($data['new']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $data['new']))) {
			$errors = true;
			$this->alert['error']['email'] = $this->language->get('error_email');
		}

		if ($column == "telephone" && ((utf8_strlen($data['new']) < 3) || utf8_strlen($data['new']) > 32)) {
			$errors = true;
			$this->alert['error']['telephone'] = $this->language->get('error_telephone');
		}

		if ($column == "product" && ((utf8_strlen($data['new']) < 1) || (utf8_strlen($data['new']) > 255))) {
			$errors = true;
			$this->alert['error']['product'] = $this->language->get('error_product');
		}

		if ($column == "model" && ((utf8_strlen($data['new']) < 1) || (utf8_strlen($data['new']) > 64))) {
			$errors = true;
			$this->alert['error']['model'] = $this->language->get('error_model');
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
		if (!$this->user->hasPermission('modify', 'sale/return')) {
			$this->alert['error']['permission'] = $this->language->get('error_permission');
			return false;
		} else {
			return true;
		}
	}
}
