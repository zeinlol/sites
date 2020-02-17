<?php
class ControllerCatalogAqeInformation extends Controller {
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

		$this->load->model('catalog/information');
		$this->load->model('catalog/aqe/information');

		$this->load->language('catalog/information');
		$this->load->language('catalog/aqe/general');
		$this->load->language('catalog/aqe/information');

		if (!$this->config->get('aqe_installed') || !$this->config->get('aqe_status')) {
			$this->response->redirect($this->url->link('catalog/information', 'token=' . $this->session->data['token'], true));
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
				$this->model_catalog_information->deleteInformation($item_id);
			}

			$this->session->data['success'] = sprintf($this->language->get('text_success_delete'), count($this->request->post['selected']));

			$url = '';

			foreach($this->config->get('aqe_catalog_information') as $column => $attr) {
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

			$this->response->redirect($this->url->link('catalog/information', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_saving'] = $this->language->get('text_saving');
		$data['text_deleting'] = $this->language->get('text_deleting');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_batch_edit'] = $this->language->get('text_batch_edit');
		$data['text_autocomplete'] = $this->language->get('text_autocomplete');
		$data['text_store'] = $this->language->get('text_store');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_clear_filter'] = $this->language->get('text_clear_filter');
		$data['text_filter'] = $this->language->get('text_filter');
		// $data['text_descriptions'] = $this->language->get('text_descriptions');
		$data['text_confirm_delete'] = $this->language->get('text_confirm_delete');
		$data['text_are_you_sure'] = $this->language->get('text_are_you_sure');
		$data['text_toggle_navigation'] = $this->language->get('text_toggle_navigation');
		$data['text_toggle_dropdown'] = $this->language->get('text_toggle_dropdown');

		$data['column_title'] = $this->language->get('column_title');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_id'] = $this->language->get('column_id');
		$data['column_seo'] = $this->language->get('column_seo');
		$data['column_bottom'] = $this->language->get('column_bottom');
		$data['column_store'] = $this->language->get('column_store');
		$data['column_view_in_store'] = $this->language->get('column_view_in_store');

		$data['error_ajax_request'] = $this->language->get('error_ajax_request');
		$data['error_update'] = $this->language->get('error_update');
		$data['error_load_popup'] = $this->language->get('error_load_popup');
		$data['error_duplicate_seo_keyword'] = $this->language->get('error_duplicate_seo_keyword');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_close'] = $this->language->get('button_close');
		$data['button_save'] = $this->language->get('button_save');

		$data['aqe_tooltip'] = ($this->config->get('aqe_quick_edit_on') == 'dblclick') ? $this->language->get('text_double_click_edit') : $this->language->get('text_click_edit');
		$data['aqe_quick_edit_on'] = $this->config->get('aqe_quick_edit_on');
		$data['aqe_multilingual_seo'] = $this->config->get('aqe_multilingual_seo');
		$data['aqe_row_hover_highlighting'] = $this->config->get('aqe_row_hover_highlighting');
		$data['aqe_alternate_row_colour'] = $this->config->get('aqe_alternate_row_colour');

		$this->document->addScript('view/javascript/aqe/catalog.min.js');

		$this->document->addStyle('view/stylesheet/aqe/css/catalog.min.css');

		$filters = array();

		foreach($this->config->get('aqe_catalog_information') as $column => $attr) {
			$filters[$column] = (isset($this->request->get['filter_' . $column])) ? $this->request->get['filter_' . $column] : null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'id.title';
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

		foreach($this->config->get('aqe_catalog_information') as $column => $attr) {
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
			'href'      => $this->url->link('catalog/information', 'token=' . $this->session->data['token'] . $url, true),
			'active'    => true
		);

		$data['add'] = $this->url->link('catalog/information/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/information/delete', 'token=' . $this->session->data['token'] . $url, true);

		if ($this->config->get('config_seo_url')) {
			if (version_compare(VERSION, '2.2.0', '>=')) {
				if (class_exists('VQMod')) {
					require_once(VQMod::modCheck((DIR_APPLICATION . '../catalog/controller/startup/seo_url.php')));
				} else {
					// TODO: try loading OCMODed file
					require_once(DIR_APPLICATION . '../catalog/controller/startup/seo_url.php');
				}
				$seo_url = new ControllerStartupSeoUrl($this->registry);
			} else {
				// Require the SEO class directly from relative path to /admin/index.php
				if (class_exists('VQMod')) {
					require_once(VQMod::modCheck((DIR_APPLICATION . '../catalog/controller/common/seo_url.php')));
				} else {
					require_once(DIR_APPLICATION . '../catalog/controller/common/seo_url.php');
				}
				$seo_url = new ControllerCommonSeoUrl($this->registry);
			}
		}

		if (version_compare(VERSION, '2.2.0', '>=')) {
			$_url = new Url($this->config->get('config_secure') ? HTTP_CATALOG : HTTPS_CATALOG);
			$_url->setDomain(HTTP_CATALOG);
		} else {
			$_url = new Url(HTTP_CATALOG, $this->config->get('config_secure') ? HTTP_CATALOG : HTTPS_CATALOG);
		}

		// Check if SEO is enabled
		if ($this->config->get('config_seo_url')) {
			$_url->addRewrite($seo_url);
		}

		$this->load->model('setting/store');

		$stores = $this->model_setting_store->getStores();

		$multistore = count($stores);

		$data['stores'] = array();

		$data['stores'][0] = array(
			'name'  => $this->config->get('config_name'),
			'url'   => HTTP_CATALOG,
			'ssl'   => HTTPS_CATALOG,
			'make'  => $_url
		);

		foreach ($stores as $store) {
			$query = $this->db->query("SELECT value FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store['store_id'] . "' AND `key` = 'config_secure'");
			$secure = (int)$query->row['value'];

			if (version_compare(VERSION, '2.2.0', '>=')) {
				$_url = new Url($secure ? $store['url'] : $store['ssl']);
				$_url->setDomain($store['url']);
			} else {
				$_url = new Url($store['url'], $secure ? $store['url'] : $store['ssl']);
			}

			$data['stores'][$store['store_id']] = array(
				'name'  => $store['name'],
				'url'   => $store['url'],
				'ssl'   => $store['ssl'],
				'make'  => $_url
			);

			if ($this->config->get('config_seo_url')) {
				$data['stores'][$store['store_id']]['make']->addRewrite($seo_url);
			}
		}

		$actions = array(
			'descriptions'      => array('display' => 1, 'index' =>  2, 'short' => 'desc',  'type' =>   'descr_qe', 'class' =>            '', 'rel' => array()),
			'view'              => array('display' => 1, 'index' =>  3, 'short' => 'vw',    'type' =>       'view', 'class' =>            '', 'rel' => array()),
			'edit'              => array('display' => 1, 'index' =>  4, 'short' => 'ed',    'type' =>       'edit', 'class' => 'btn-primary', 'rel' => array()),
		);

		$actions = array_filter($actions, 'column_display');
		foreach ($actions as $action => $attr) {
			$actions[$action]['name'] = $this->language->get('action_' . $action);
		}
		uasort($actions, 'column_sort');
		$data['information_actions'] = $actions;

		$columns = $this->config->get('aqe_catalog_information');
		$columns = array_filter($columns, 'column_display');
		foreach ($columns as $column => $attr) {
			$columns[$column]['name'] = $this->language->get('column_' . $column);

			if ($column == 'view_in_store' && !$multistore) {
				unset($columns[$column]);
			}
		}
		uasort($columns, 'column_sort');
		$data['information_columns'] = $columns;

		$displayed_columns = array_keys($columns);
		$displayed_actions = array_keys($actions);
		$related_columns = array_merge(array_map(function($v) { return isset($v['rel']) ? $v['rel'] : ''; }, $columns), array_map(function($v) { return isset($v['rel']) ? $v['rel'] : ''; }, $actions));

		$data['informations'] = array();

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

		$results = $this->model_catalog_aqe_information->getInformations($filter_data);

		$information_total = $this->model_catalog_aqe_information->getTotalInformations();

		foreach ($results as $result) {
			$_buttons = array();

			foreach ($actions as $action => $attr) {
				switch ($action) {
					case 'edit':
						$_buttons[] = array(
							'type'  => $attr['type'],
							'action'=> $action,
							'title' => $this->language->get('action_' . $action),
							'url'   => html_entity_decode($this->url->link('catalog/information/edit', '&information_id=' . $result['information_id'] . '&token=' . $this->session->data['token'] . $url, true), ENT_QUOTES, 'UTF-8'),
							'icon'  => 'pencil',
							'name'  => null,
							'rel'   => json_encode(array()),
							'class' => $attr['class'],
						);
						break;
					case 'view':
						$_buttons[] = array(
							'type'  => $attr['type'],
							'action'=> $action,
							'title' => $this->language->get('action_' . $action),
							'url'   => html_entity_decode($_url->link('information/information&information_id=' . $result['information_id']), ENT_QUOTES, 'UTF-8'),
							'icon'  => 'eye',
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
				'information_id'=> $result['information_id'],
				'selected'   => isset($this->request->post['selected']) && in_array($result['information_id'], $this->request->post['selected']),
				'action'     => $_buttons
			);
			if (!is_array($columns)) {
				$row['title'] = $result['title'];
				$row['sort_order'] = $result['sort_order'];
			} else {
				foreach ($columns as $column => $attr) {
					if ($column == 'store') {
						$stores = $this->model_catalog_information->getInformationStores($result['information_id']);
						$information_stores = array();
						foreach($stores as $store) {
							$information_stores[] = $data['stores'][$store]['name'];
						}
						$row[$column] = implode("<br />", $information_stores);
					} else if ($column == 'bottom') {
						$row[$column] = ($result['bottom'] ? $this->language->get('text_yes') : $this->language->get('text_no'));
					} else if ($column == 'status') {
						if ((int)$result['status'] || !$this->config->get('aqe_highlight_status')) {
							$row[$column] = ((int)$result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'));
						} else {
							$row[$column] = ((int)$result['status'] ? $this->language->get('text_enabled') : '<span style="color:#FF0000;">' . $this->language->get('text_disabled') . '</span>');
						}
					} else if ($column == 'id') {
						$row[$column] = $result['information_id'];
					} else if ($column == 'action') {
						$row[$column] = $_buttons;
					} else if ($column == 'selector') {
						$row[$column] = '';
					} else if ($column == 'view_in_store') {
						$information_stores = $this->model_catalog_information->getInformationStores($result['information_id']);

						$row[$column] = array();

						foreach ($information_stores as $store) {
							if (!in_array($store, array_keys($data['stores'])))
								continue;
							$row[$column][] = array(
								'name' => $data['stores'][$store]['name'],
								'href' => $data['stores'][$store]['make']->link('information/information&information_id=' . $result['information_id'])
							);
						}
					} else {
						$row[$column] = $result[$column];
					}
				}
			}
			$data['informations'][] = $row;
		}

		$data['language_id'] = $this->config->get('config_language_id');

		$column_classes = array();
		$type_classes = array();
		$non_sortable = array();

		if (!is_array($columns)) {
			$displayed_columns = array('selector', 'title', 'sort_order', 'action');
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

		$data['update_url'] = html_entity_decode($this->url->link('catalog/information/quick_update', 'token=' . $this->session->data['token'], true));
		$data['refresh_url'] = html_entity_decode($this->url->link('catalog/information/refresh_data', 'token=' . $this->session->data['token'], true));
		$data['load_popup_url'] = html_entity_decode($this->url->link('catalog/information/load_popup', 'token=' . $this->session->data['token'], true));
		$data['status_select'] = addslashes(json_encode(array(array("id" => "0", "value" => $this->language->get('text_disabled')), array("id" => "1", "value" => $this->language->get('text_enabled')))));
		$data['yes_no_select'] = addslashes(json_encode(array(array("id" => "0", "value" => $this->language->get('text_no')), array("id" => "1", "value" => $this->language->get('text_yes')))));


		$this->load->model('localisation/language');
		$lang_count = $this->model_localisation_language->getTotalLanguages();
		$data['single_lang_editing'] = $this->config->get('aqe_single_language_editing') || ((int)$lang_count == 1);
		$data['batch_edit'] = (int)$this->config->get('aqe_batch_edit');

		$data['token'] = $this->session->data['token'];

		$url = '';

		foreach ($this->config->get('aqe_catalog_information') as $column => $attr) {
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
		foreach ($this->config->get('aqe_catalog_information') as $column => $attr) {
			$data['sorts'][$column] = $this->url->link('catalog/information', 'token=' . $this->session->data['token'] . '&sort=' . $attr['sort'] . $url, true);
		}

		$url = '';

		foreach ($this->config->get('aqe_catalog_information') as $column => $attr) {
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
		$pagination->total = $information_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/information', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($information_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($information_total - $this->config->get('config_limit_admin'))) ? $information_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $information_total, ceil($information_total / $this->config->get('config_limit_admin')));

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
			$template = 'catalog/aqe/information_list';
		} else {
			$template = 'catalog/aqe/information_list.tpl';
		}

		$this->response->setOutput($this->load->view($template, $data));
	}

	public function autocomplete() {
		$response = array();

		if (isset($this->request->get['filter_title']) ||
			isset($this->request->get['filter_seo'])) {

			$filter_types = array('title', 'seo');
			$filters = array();

			foreach($filter_types as $filter) {
				$filters[$filter] = (isset($this->request->get['filter_' . $filter])) ? $this->request->get['filter_' . $filter] : null;
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

			$results = $this->model_catalog_aqe_information->getInformations($filter_data);

			foreach ($results as $result) {
				$response[] = array(
					'information_id'=> $result['information_id'],
					'title'      => strip_tags(html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8')),
					'seo'        => (isset($result['seo'])) ? $result['seo'] : '',
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
				case "title":
					$this->load->model('localisation/language');
					$data['languages'] = $this->model_localisation_language->getLanguages();
					$data['value'] = array();
					$descriptions = $this->model_catalog_information->getInformationDescriptions($data['i_id']);
					foreach ($descriptions as $language_id => $value) {
						$data['value'][$language_id] = $value[$data['parameter']];
					}
					// $response['title'] = $this->language->get('entry_' . $data['parameter']);
					break;
				case "seo":
					$this->load->model('localisation/language');
					$data['languages'] = $this->model_localisation_language->getLanguages();
					$data['value'] = array();
					$keywords = $this->model_catalog_aqe_information->getInformationSeoKeywords($data['i_id']);
					foreach ($keywords as $language_id => $value) {
						$data['value'][$language_id] = $value;
					}
					break;
				case "store":
					$this->load->model('setting/store');
					$data['stores'] = $this->model_setting_store->getStores();
					array_unshift($data['stores'], array("store_id" => 0, "name" => $this->config->get('config_name')));
					$data['i_s'] = $this->model_catalog_information->getInformationStores($data['i_id']);
					// $response['title'] = $this->language->get('entry_store');
					break;
				case "descriptions":
					$data['entry_description'] = $this->language->get('entry_description');
					$data['entry_meta_title'] = $this->language->get('entry_meta_title');
					$data['entry_meta_description'] = $this->language->get('entry_meta_description');
					$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');

					$this->load->model('localisation/language');
					$data['languages'] = $this->model_localisation_language->getLanguages();
					$data['i_d'] = $this->model_catalog_information->getInformationDescriptions($data['i_id']);
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
			$template = 'catalog/aqe/quick_edit_form';
		} else {
			$template = 'catalog/aqe/quick_edit_form.tpl';
		}

		$response['popup'] = $this->load->view($template, $data);

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

			foreach ((array)$id as $_id) {
				if ($this->model_catalog_aqe_information->quickEditInformation($_id, $column, $value, $lang_id, $this->request->post)) {
					$results['done'][] = $_id;
				} else {
					$results['failed'][] = $_id;
				}
			}

			$response['results'] = $results;

			if ($results['done']) {
				$this->alert['success']['update'] = $this->language->get('text_success');
				$response['success'] = 1;

				if (in_array($column, array('descriptions'))) {
					$response['value'] = $value;
					$response['values']['*'] = $response['value'];
				} else if (in_array($column, array('sort_order'))) {
					$response['value'] = (int)$value;
					$response['values']['*'] = $response['value'];
				} else if (in_array($column, array('bottom'))) {
					$response['value'] = ((int)$value) ? $this->language->get('text_yes') : $this->language->get('text_no');
					$response['values']['*'] = $response['value'];
				} else if ($column == 'status') {
					if ((int)$value || !$this->config->get('aqe_highlight_status')) {
						$response['value'] = ((int)$value) ? $this->language->get('text_enabled') : $this->language->get('text_disabled');
					} else {
						$response['value'] = ((int)$value) ? $this->language->get('text_enabled') : '<span style="color:#FF0000;">' . $this->language->get('text_disabled') . '</span>';
					}
					$response['values']['*'] = $response['value'];
				} else if(in_array($column, array('title', 'seo'))) {
					if (isset($this->request->post['value'])) {
						$response['value'] = isset($this->request->post['value'][$this->config->get('config_language_id')]) ? $this->request->post['value'][$this->config->get('config_language_id')] : '';
					} else
						$response['value'] = $value;
					$response['values']['*'] = $response['value'];
				} else if($column == 'store') {
					if (isset($this->request->post['i_s'])) {
						$this->request->post['i_s'] = (array)$this->request->post['i_s'];

						$this->load->model('setting/store');
						$stores = $this->model_setting_store->getStores();
						array_unshift($stores, array("store_id" => 0, "name" => $this->config->get('config_name')));

						$information_stores = array();

						foreach ($stores as $store) {
							if (in_array($store['store_id'], $this->request->post['i_s']))
								$information_stores[] = $store['name'];
						}
						$response['value'] = implode("<br>", $information_stores);
					} else {
						$response['value'] = "";
					}
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
		$error = !$this->validatePermissions();

		$this->load->model('setting/store');

		foreach ($this->request->post['selected'] as $information_id) {
			if ($this->config->get('config_account_id') == $information_id) {
				$error = true;
				$i = $this->model_catalog_information->getInformationDescriptions($information_id);
				$name = isset($i[$this->config->get('config_language_id')]['name']) ? $i[$this->config->get('config_language_id')]['name'] : '';
				$this->alert['warning']['delete' . $information_id] = sprintf($this->language->get('error_account'), $name, $store_total);
			}

			if ($this->config->get('config_checkout_id') == $information_id) {
				$error = true;
				$i = $this->model_catalog_information->getInformationDescriptions($information_id);
				$name = isset($i[$this->config->get('config_language_id')]['name']) ? $i[$this->config->get('config_language_id')]['name'] : '';
				$this->alert['warning']['delete' . $information_id] = sprintf($this->language->get('error_checkout'), $name, $store_total);
			}

			if ($this->config->get('config_affiliate_id') == $information_id) {
				$error = true;
				$i = $this->model_catalog_information->getInformationDescriptions($information_id);
				$name = isset($i[$this->config->get('config_language_id')]['name']) ? $i[$this->config->get('config_language_id')]['name'] : '';
				$this->alert['warning']['delete' . $information_id] = sprintf($this->language->get('error_affiliate'), $name, $store_total);
			}

			if ($this->config->get('config_return_id') == $information_id) {
				$error = true;
				$i = $this->model_catalog_information->getInformationDescriptions($information_id);
				$name = isset($i[$this->config->get('config_language_id')]['name']) ? $i[$this->config->get('config_language_id')]['name'] : '';
				$this->alert['warning']['delete' . $information_id] = sprintf($this->language->get('error_return'), $name, $store_total);
			}

			$store_total = $this->model_setting_store->getTotalStoresByInformationId($information_id);

			if ($store_total) {
				$error = true;
				$i = $this->model_catalog_information->getInformationDescriptions($information_id);
				$name = isset($i[$this->config->get('config_language_id')]['name']) ? $i[$this->config->get('config_language_id')]['name'] : '';
				$this->alert['warning']['delete' . $information_id] = sprintf($this->language->get('error_store'), $name, $store_total);
			}
		}

		return !$error;
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

		if ($column == "title") {
			if (isset($data['value'])) {
				foreach ((array)$data['value'] as $language_id => $value) {
					if ((utf8_strlen($value) < 3) || (utf8_strlen($value) > 64)) {
						$errors = true;
						$this->error["value[$language_id]"] = $this->language->get('error_title');
					}
				}
			} else {
				if ((utf8_strlen($data['new']) < 1) || (utf8_strlen($data['new']) > 64)) {
					$errors = true;
					$this->alert['error']['title'] = $this->language->get('error_title');
				}
			}
		}

		if ($column == "descriptions") {
			if (isset($data['description'])) {
				foreach ((array)$data['description'] as $language_id => $value) {
					if ((utf8_strlen($value['description']) < 3)) {
						$errors = true;
						$this->error["description[$language_id][description]"] = $this->language->get('error_description');
					}

					if (!isset($value['meta_title']) || utf8_strlen($value['meta_title']) < 3 || utf8_strlen($value['meta_title']) > 255) {
						$errors = true;
						$this->error["description[$language_id][meta_title]"] = $this->language->get('error_meta_title');
					}
				}
			}
		}

		if ($column == "seo") {
			if (isset($data['ids']) && count((array)$data['ids']) > 1) {
				$errors = true;
				$this->alert['error']['seo'] = $this->language->get('error_batch_edit_seo');
			} else {
				$multilingual_seo = $this->config->get('aqe_multilingual_seo');

				if (isset($data['value']) && $multilingual_seo) {
					foreach ((array)$data['value'] as $language_id => $value) {
						$keyword = utf8_decode($value);
						if ($this->model_catalog_aqe_information->urlAliasExists($id, $keyword, $language_id)) {
							$errors = true;
							$this->error["value[$language_id]"] = $this->language->get('error_duplicate_seo_keyword');
						}
					}
				} else {
					$keyword = utf8_decode($data['new']);
					if ($this->model_catalog_aqe_information->urlAliasExists($id, $keyword)) {
						$errors = true;
						$this->alert['error']['seo'] = $this->language->get('error_duplicate_seo_keyword');
					}
				}
			}
		}

		if (in_array($column, array("store"))) {
			if (!isset($data['i_id'])) {
				$errors = true;
				$this->alert['error']['request'] = $this->language->get('error_update');
			}
		}

		if ($this->error && !isset($this->alert['warning']['warning'])) {
			$this->alert['warning']['warning'] = $this->language->get('error_warning');
		}

		return !$errors;
	}

	private function validatePermissions() {
		if (!$this->user->hasPermission('modify', 'catalog/information')) {
			$this->alert['error']['permission'] = $this->language->get('error_permission');
			return false;
		} else {
			return true;
		}
	}
}
