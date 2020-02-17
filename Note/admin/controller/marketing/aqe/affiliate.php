<?php
class ControllerMarketingAqeAffiliate extends Controller {
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

		$this->load->model('marketing/affiliate');
		$this->load->model('marketing/aqe/affiliate');

		$this->load->language('marketing/affiliate');
		$this->load->language('marketing/aqe/general');
		$this->load->language('marketing/aqe/affiliate');

		if (!$this->config->get('aqe_installed') || !$this->config->get('aqe_status')) {
			$this->response->redirect($this->url->link('marketing/affiliate', 'token=' . $this->session->data['token'], true));
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
				$this->model_marketing_affiliate->deleteAffiliate($item_id);
			}

			$this->session->data['success'] = sprintf($this->language->get('text_success_delete'), count($this->request->post['selected']));

			$url = '';

			foreach($this->config->get('aqe_marketing_affiliates') as $column => $attr) {
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

			$this->response->redirect($this->url->link('marketing/affiliate', 'token=' . $this->session->data['token'] . $url, true));
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
		$data['column_email'] = $this->language->get('column_email');
		$data['column_telephone'] = $this->language->get('column_telephone');
		$data['column_fax'] = $this->language->get('column_fax');
		$data['column_company'] = $this->language->get('column_company');
		$data['column_address_1'] = $this->language->get('column_address_1');
		$data['column_address_2'] = $this->language->get('column_address_2');
		$data['column_city'] = $this->language->get('column_city');
		$data['column_postcode'] = $this->language->get('column_postcode');
		$data['column_country'] = $this->language->get('column_country');
		$data['column_region'] = $this->language->get('column_region');
		$data['column_tracking_code'] = $this->language->get('column_tracking_code');
		$data['column_commission'] = $this->language->get('column_commission');
		$data['column_tax'] = $this->language->get('column_tax');
		$data['column_balance'] = $this->language->get('column_balance');
		$data['column_approved'] = $this->language->get('column_approved');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_ip'] = $this->language->get('column_ip');
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

		foreach($this->config->get('aqe_marketing_affiliates') as $column => $attr) {
			$filters[$column] = (isset($this->request->get['filter_' . $column])) ? $this->request->get['filter_' . $column] : null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
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

		foreach($this->config->get('aqe_marketing_affiliates') as $column => $attr) {
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
			'href'      => $this->url->link('marketing/affiliate', 'token=' . $this->session->data['token'] . $url, true),
			'active'    => true
		);

		$data['add'] = $this->url->link('marketing/affiliate/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('marketing/affiliate/delete', 'token=' . $this->session->data['token'] . $url, true);

		$actions = array(
			'approve'           => array('display' => 1, 'index' =>  1, 'short' => 'apr',   'type' =>       'link', 'class' => 'btn-success', 'icon' => 'thumbs-o-up', 'rel' => array()),
			'unlock'            => array('display' => 1, 'index' =>  3, 'short' => 'ul',    'type' =>       'link', 'class' => 'btn-warning', 'icon' => 'unlock', 'rel' => array()),
			'edit'              => array('display' => 1, 'index' =>  4, 'short' => 'ed',    'type' =>       'edit', 'class' => 'btn-primary', 'icon' => 'pencil', 'rel' => array()),
		);

		$actions = array_filter($actions, 'column_display');
		foreach ($actions as $action => $attr) {
			$actions[$action]['name'] = $this->language->get('action_' . $action);
		}
		uasort($actions, 'column_sort');
		$data['affiliate_actions'] = $actions;

		$columns = $this->config->get('aqe_marketing_affiliates');
		$columns = array_filter($columns, 'column_display');
		foreach ($columns as $column => $attr) {
			$columns[$column]['name'] = $this->language->get('column_' . $column);
		}
		uasort($columns, 'column_sort');
		$data['affiliate_columns'] = $columns;

		$displayed_columns = array_keys($columns);
		$displayed_actions = array_keys($actions);
		$related_columns = array_merge(array_map(function($v) { return isset($v['rel']) ? $v['rel'] : ''; }, $columns), array_map(function($v) { return isset($v['rel']) ? $v['rel'] : ''; }, $actions));

		$data['affiliates'] = array();

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

		$results = $this->model_marketing_aqe_affiliate->getAffiliates($filter_data);

		$affiliate_total = $this->model_marketing_aqe_affiliate->getTotalAffiliates();

		foreach ($results as $result) {
			$_buttons = array();

			foreach ($actions as $action => $attr) {
				switch ($action) {
					case 'edit':
						$_buttons[] = array(
							'type'  => $attr['type'],
							'action'=> $action,
							'title' => $this->language->get('action_' . $action),
							'url'   => html_entity_decode($this->url->link('marketing/affiliate/edit', '&affiliate_id=' . $result['affiliate_id'] . '&token=' . $this->session->data['token'] . $url, true), ENT_QUOTES, 'UTF-8'),
							'icon'  => $attr['icon'],
							'name'  => null,
							'rel'   => json_encode($attr['rel']),
							'class' => $attr['class'],
						);
						break;
					case 'approve':
						$_buttons[] = array(
							'type'  => $attr['type'],
							'action'=> $action,
							'title' => $this->language->get('action_' . $action),
							'url'   => !$result['approved'] ? html_entity_decode($this->url->link('marketing/affiliate/approve', '&affiliate_id=' . $result['affiliate_id'] . '&token=' . $this->session->data['token'] . $url, true), ENT_QUOTES, 'UTF-8') : '',
							'icon'  => $attr['icon'],
							'name'  => null,
							'rel'   => json_encode($attr['rel']),
							'class' => $attr['class'],
						);
						break;
					case 'unlock':
						$login_info = $this->model_marketing_affiliate->getTotalLoginAttempts($result['email']);

						$_buttons[] = array(
							'type'  => $attr['type'],
							'action'=> $action,
							'title' => $this->language->get('action_' . $action),
							'url'   => ($login_info && $login_info['total'] >= $this->config->get('config_login_attempts')) ? html_entity_decode($this->url->link('marketing/affiliate/unlock', '&email=' . $result['email'] . '&token=' . $this->session->data['token'] . $url, true), ENT_QUOTES, 'UTF-8') : '',
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
				'affiliate_id'  => $result['affiliate_id'],
				'selected'   => isset($this->request->post['selected']) && in_array($result['affiliate_id'], $this->request->post['selected']),
				'action'     => $_buttons
			);
			if (!is_array($columns)) {
				$row['name'] = $result['name'];
				$row['email'] = $result['email'];
				$row['balance'] = $result['balance'];
				$row['status'] = $result['status'];
				$row['date_added'] = $result['date_added'];
			} else {
				foreach ($columns as $column => $attr) {
					if (in_array($column, array('approved'))) {
						$row[$column] = ($result[$column] ? $this->language->get('text_yes') : $this->language->get('text_no'));
					} else if ($column == 'status') {
						if ((int)$result['status'] || !$this->config->get('aqe_highlight_status')) {
							$row[$column] = ((int)$result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'));
						} else {
							$row[$column] = ((int)$result['status'] ? $this->language->get('text_enabled') : '<span style="color:#FF0000;">' . $this->language->get('text_disabled') . '</span>');
						}
					} else if ($column == 'balance') {
						$row[$column] =$this->currency->format($result[$column], $this->config->get('config_currency'));
					} else if ($column == 'id') {
						$row[$column] = $result['affiliate_id'];
					} else if (in_array($column, array('date_added'))) {
						$date = new DateTime($result[$column]);
						$row[$column] = $date->format("Y-m-d");
					} else if ($column == 'commission') {
						$row[$column] = number_format(round($result[$column], 2), 2, '.', '') . " %";
					} else if ($column == 'action') {
						$row[$column] = $_buttons;
					} else if ($column == 'selector') {
						$row[$column] = '';
					} else {
						$row[$column] = $result[$column];
					}
				}
			}
			$data['affiliates'][] = $row;
		}

		$data['language_id'] = $this->config->get('config_language_id');

		$column_classes = array();
		$type_classes = array();
		$non_sortable = array();

		if (!is_array($columns)) {
			$displayed_columns = array('selector', 'name', 'email', 'balance', 'status', 'date_added', 'action');
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

		$data['update_url'] = html_entity_decode($this->url->link('marketing/affiliate/quick_update', 'token=' . $this->session->data['token'], true));
		$data['load_popup_url'] = html_entity_decode($this->url->link('marketing/affiliate/load_popup', 'token=' . $this->session->data['token'], true));
		$data['load_zone_url'] = html_entity_decode($this->url->link('marketing/affiliate/load_zone', 'token=' . $this->session->data['token'], true));

		$data['yes_no_select'] = addslashes(json_encode(array(array("id" => "0", "value" => $this->language->get('text_no')), array("id" => "1", "value" => $this->language->get('text_yes')))));
		$data['status_select'] = addslashes(json_encode(array(array("id" => "0", "value" => $this->language->get('text_disabled')), array("id" => "1", "value" => $this->language->get('text_enabled')))));

		$data['batch_edit'] = (int)$this->config->get('aqe_batch_edit');

		if (in_array("country", $displayed_columns)) {
			$this->load->model('localisation/country');
			$data['countries'] = $this->model_localisation_country->getCountries();
			$c_select = array();
			foreach ($data['countries'] as $c) {
				$c_select[] = array("id" => $c['country_id'], "value" => $c['name']);
			}
			$data['country_select'] = addslashes(json_enc($c_select, JSON_UNESCAPED_SLASHES));
		} else {
			$data['country_select'] = addslashes(json_encode(array()));
		}

		$data['token'] = $this->session->data['token'];

		$url = '';

		foreach ($this->config->get('aqe_marketing_affiliates') as $column => $attr) {
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
		foreach ($this->config->get('aqe_marketing_affiliates') as $column => $attr) {
			$data['sorts'][$column] = $this->url->link('marketing/affiliate', 'token=' . $this->session->data['token'] . '&sort=' . $attr['sort'] . $url, true);
		}

		$url = '';

		foreach ($this->config->get('aqe_marketing_affiliates') as $column => $attr) {
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
		$pagination->total = $affiliate_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('marketing/affiliate', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($affiliate_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($affiliate_total - $this->config->get('config_limit_admin'))) ? $affiliate_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $affiliate_total, ceil($affiliate_total / $this->config->get('config_limit_admin')));

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
			$template = 'marketing/aqe/affiliate_list';
		} else {
			$template = 'marketing/aqe/affiliate_list.tpl';
		}

		$this->response->setOutput($this->load->view($template, $data));
	}

	public function autocomplete() {
		$response = array();

		if (isset($this->request->get['filter_name']) ||
			isset($this->request->get['filter_email'])) {

			$filter_types = array('name', 'email');
			$filters = array();

			foreach ($filter_types as $filter) {
				if (isset($this->request->get['filter_' . $filter])) {
					$filters[$filter] = $this->request->get['filter_' . $filter];
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

			$results = $this->model_marketing_aqe_affiliate->getAffiliates($filter_data);

			foreach ($results as $result) {
				$response[] = array(
					'affiliate_id'=> $result['affiliate_id'],
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'email'       => $result['email'],
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
				case "name":
					$data['text_first_name'] = $this->language->get('text_first_name');
					$data['text_last_name'] = $this->language->get('text_last_name');

					$return = $this->model_marketing_affiliate->getAffiliate($data['i_id']);
					$data['first_name'] = $return['firstname'];
					$data['last_name'] = $return['lastname'];
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

	public function load_zone() {
		$response = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateLoadData($this->request->post)) {
			list($column, $id) = explode("-", $this->request->post['id']);

			$affiliate = $this->model_marketing_affiliate->getAffiliate($id);

			if ($affiliate) {
				$this->load->model('localisation/zone');
				$results = $this->model_localisation_zone->getZonesByCountryId($affiliate['country_id']);
				$zones = array();
				$found = false;
				foreach ($results as $result) {
					$zones[$result['zone_id']] = $result['name'];
					if ($result['zone_id'] == $affiliate['zone_id'])
						$found = true;
				}
				if ($found) {
					$zones['selected'] = $affiliate['zone_id'];
				} else {
					$zones = array("0" => "") + $zones;
					$zones['selected'] = "0";
				}
				$response['select'] = $zones;
			} else {
				$this->alert['error']['load'] = $this->language->get('error_load_zone');
			}
		} else {
			$this->alert['error']['load'] = $this->language->get('error_load_zone');
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

			if ($column == 'approve') {
				foreach ((array)$id as $_id) {
					$this->model_marketing_affiliate->approve($_id);
					$results['done'][] = $_id;
				}
			} else {
				foreach ((array)$id as $_id) {
					if ($this->model_marketing_aqe_affiliate->quickEditAffiliate($_id, $column, $value, $lang_id, $this->request->post)) {
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

				if (in_array($column, array('email', 'telephone', 'fax', 'company', 'address_1', 'address_2', 'city', 'postcode', 'tracking_code', 'tax'))) {
					$response['value'] = $value;
					$response['values']['*'] = $response['value'];
				} else if (in_array($column, array('approved'))) {
					$response['value'] = ((int)$value) ? $this->language->get('text_yes') : $this->language->get('text_no');
					$response['values']['*'] = $response['value'];
				} else if ($column == 'status') {
					if ((int)$value || !$this->config->get('aqe_highlight_status')) {
						$response['value'] = ((int)$value) ? $this->language->get('text_enabled') : $this->language->get('text_disabled');
					} else {
						$response['value'] = ((int)$value) ? $this->language->get('text_enabled') : '<span style="color:#FF0000;">' . $this->language->get('text_disabled') . '</span>';
					}
					$response['values']['*'] = $response['value'];
				} else if ($column == 'country') {
					$this->load->model('localisation/country');
					$country = $this->model_localisation_country->getCountry((int)$value);
					if ($country)
						$response['value'] = $country['name'];
					else
						$response['value'] = '';
					$response['values']['*'] = $response['value'];
				} else if ($column == 'region') {
					$this->load->model('localisation/zone');
					$zone = $this->model_localisation_zone->getZone((int)$value);
					if ($zone)
						$response['value'] = $zone['name'];
					else
						$response['value'] = '';
					$response['values']['*'] = $response['value'];
				} else if ($column == 'name') {
					$response['value'] = $this->request->post['first_name'] . ' ' . $this->request->post['last_name'];
					$response['values']['*'] = $response['value'];
				} else if ($column == 'commission') {
					$response['value'] = number_format(round($value, 2), 2, '.', '') . " %";
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

	protected function validateLoadData(&$data) {
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

		if ($column == "name") {
			if ((utf8_strlen(trim($data['first_name'])) < 1) || (utf8_strlen(trim($data['first_name'])) > 32)) {
				$errors = true;
				$this->error['first_name'] = $this->language->get('error_firstname');
			}
			if ((utf8_strlen(trim($data['last_name'])) < 1) || (utf8_strlen(trim($data['last_name'])) > 32)) {
				$errors = true;
				$this->error['last_name'] = $this->language->get('error_lastname');
			}
		}

		if ($column == "email") {
			$affiliate_info = $this->model_marketing_affiliate->getAffiliateByEmail($data['new']);

			if (isset($data['ids']) && count((array)$data['ids']) > 1) {
				$errors = true;
				$this->alert['error']['request'] = $this->language->get('error_batch_edit_email');
			} else if (((utf8_strlen($data['new']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $data['new']))) {
				$errors = true;
				$this->alert['error']['email'] = $this->language->get('error_email');
			} else if ($affiliate_info && $id != $affiliate_info['affiliate_id']) {
				$errors = true;
				$this->alert['error']['email'] = $this->language->get('error_exists');
			}
		}

		if ($column == "telephone" && ((utf8_strlen($data['new']) < 3) || utf8_strlen($data['new']) > 32)) {
			$errors = true;
			$this->alert['error']['telephone'] = $this->language->get('error_telephone');
		}

		if ($column == "address_1" && ((utf8_strlen(trim($data['new'])) < 3) || utf8_strlen(trim($data['new'])) > 128)) {
			$errors = true;
			$this->alert['error']['address_1'] = $this->language->get('error_address_1');
		}

		if ($column == "city" && ((utf8_strlen(trim($data['new'])) < 2) || utf8_strlen(trim($data['new'])) > 128)) {
			$errors = true;
			$this->alert['error']['city'] = $this->language->get('error_city');
		}

		if ($column == "country") {
			$this->load->model('localisation/country');
			$affiliate_info = $this->model_marketing_affiliate->getAffiliate($id);
			$country_info = $this->model_localisation_country->getCountry($data['new']);

			if ($country_info && $affiliate_info && $country_info['postcode_required'] && (utf8_strlen(trim($affiliate_info['postcode'])) < 2) || (utf8_strlen(trim($affiliate_info['postcode'])) > 10)) {
				$this->alert['error']['postcode'] = $this->language->get('error_postcode');
			}

			if ($data['new'] == '') {
				$this->alert['error']['country'] = $this->language->get('error_country');
			}
		}

		if ($column == "region" && $data['new'] == '') {
			$errors = true;
			$this->alert['error']['region'] = $this->language->get('error_zone');
		}

		if ($column == "tracking_code" && $data['new'] == '') {
			$errors = true;
			$this->alert['error']['tracking_code'] = $this->language->get('error_code');
		}

		if ($this->error && !isset($this->alert['warning']['warning'])) {
			$this->alert['warning']['warning'] = $this->language->get('error_warning');
		}

		return !$errors;
	}

	private function validatePermissions() {
		if (!$this->user->hasPermission('modify', 'marketing/affiliate')) {
			$this->alert['error']['permission'] = $this->language->get('error_permission');
			return false;
		} else {
			return true;
		}
	}
}
