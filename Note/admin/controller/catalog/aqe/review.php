<?php
class ControllerCatalogAqeReview extends Controller {
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

		$this->load->model('catalog/review');
		$this->load->model('catalog/aqe/review');

		$this->load->language('catalog/review');
		$this->load->language('catalog/aqe/general');
		$this->load->language('catalog/aqe/review');

		if (!$this->config->get('aqe_installed') || !$this->config->get('aqe_status')) {
			$this->response->redirect($this->url->link('catalog/review', 'token=' . $this->session->data['token'], true));
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
				$this->model_catalog_review->deleteReview($item_id);
			}

			$this->session->data['success'] = sprintf($this->language->get('text_success_delete'), count($this->request->post['selected']));

			$url = '';

			foreach($this->config->get('aqe_catalog_reviews') as $column => $attr) {
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

			$this->response->redirect($this->url->link('catalog/review', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_no_results'] = $this->language->get('text_no_results');
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

		$data['column_product'] = $this->language->get('column_product');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');
		$data['column_author'] = $this->language->get('column_author');
		$data['column_id'] = $this->language->get('column_id');
		$data['column_text'] = $this->language->get('column_text');
		$data['column_rating'] = $this->language->get('column_rating');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_date_modified'] = $this->language->get('column_date_modified');

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
		$data['button_ok'] = $this->language->get('button_ok');

		$data['aqe_tooltip'] = ($this->config->get('aqe_quick_edit_on') == 'dblclick') ? $this->language->get('text_double_click_edit') : $this->language->get('text_click_edit');
		$data['aqe_quick_edit_on'] = $this->config->get('aqe_quick_edit_on');
		$data['aqe_multilingual_seo'] = $this->config->get('aqe_multilingual_seo');
		$data['aqe_row_hover_highlighting'] = $this->config->get('aqe_row_hover_highlighting');
		$data['aqe_alternate_row_colour'] = $this->config->get('aqe_alternate_row_colour');

		$this->document->addScript('view/javascript/aqe/catalog.min.js');

		$this->document->addStyle('view/stylesheet/aqe/css/catalog.min.css');

		$filters = array();

		foreach($this->config->get('aqe_catalog_reviews') as $column => $attr) {
			$filters[$column] = (isset($this->request->get['filter_' . $column])) ? $this->request->get['filter_' . $column] : null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'r.date_added';
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

		foreach($this->config->get('aqe_catalog_reviews') as $column => $attr) {
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
			'href'      => $this->url->link('catalog/review', 'token=' . $this->session->data['token'] . $url, true),
			'active'    => true
		);

		$data['add'] = $this->url->link('catalog/review/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/review/delete', 'token=' . $this->session->data['token'] . $url, true);

		$actions = array(
			'edit'              => array('display' => 1, 'index' =>  4, 'short' => 'ed',    'type' =>       'edit', 'class' => 'btn-primary', 'rel' => array()),
		);

		$actions = array_filter($actions, 'column_display');
		foreach ($actions as $action => $attr) {
			$actions[$action]['name'] = $this->language->get('action_' . $action);
		}
		uasort($actions, 'column_sort');
		$data['review_actions'] = $actions;

		$columns = $this->config->get('aqe_catalog_reviews');
		$columns = array_filter($columns, 'column_display');
		foreach ($columns as $column => $attr) {
			$columns[$column]['name'] = $this->language->get('column_' . $column);

			if ($column == 'view_in_store' && !$multistore) {
				unset($columns[$column]);
			}
		}
		uasort($columns, 'column_sort');
		$data['review_columns'] = $columns;

		$displayed_columns = array_keys($columns);
		$displayed_actions = array_keys($actions);
		$related_columns = array_merge(array_map(function($v) { return isset($v['rel']) ? $v['rel'] : ''; }, $columns), array_map(function($v) { return isset($v['rel']) ? $v['rel'] : ''; }, $actions));

		$data['reviews'] = array();

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

		$results = $this->model_catalog_aqe_review->getReviews($filter_data);

		$review_total = $this->model_catalog_aqe_review->getTotalReviews();

		foreach ($results as $result) {
			$_buttons = array();

			foreach ($actions as $action => $attr) {
				switch ($action) {
					case 'edit':
						$_buttons[] = array(
							'type'  => $attr['type'],
							'action'=> $action,
							'title' => $this->language->get('action_' . $action),
							'url'   => html_entity_decode($this->url->link('catalog/review/edit', '&review_id=' . $result['review_id'] . '&token=' . $this->session->data['token'] . $url, true), ENT_QUOTES, 'UTF-8'),
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
							'url'   => html_entity_decode(HTTP_CATALOG . 'index.php?route=product/product&product_id=' . $result['product_id'], ENT_QUOTES, 'UTF-8'),
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
				'review_id'  => $result['review_id'],
				'selected'   => isset($this->request->post['selected']) && in_array($result['review_id'], $this->request->post['selected']),
				'action'     => $_buttons
			);
			if (!is_array($columns)) {
				$row['name'] = $result['name'];
				$row['product'] = $result['product'];
				$row['author'] = $result['author'];
				$row['rating'] = $result['rating'];
				$row['date_added'] = date($this->language->get('date_format_short'), strtotime($result['date_added']));
				$row['status'] = ((int)$result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'));
			} else {
				foreach ($columns as $column => $attr) {
					if ($column == 'status') {
						if ((int)$result['status'] || !$this->config->get('aqe_highlight_status')) {
							$row[$column] = ((int)$result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'));
						} else {
							$row[$column] = ((int)$result['status'] ? $this->language->get('text_enabled') : '<span style="color:#FF0000;">' . $this->language->get('text_disabled') . '</span>');
						}
					} else if ($column == 'id') {
						$row[$column] = $result['review_id'];
					} else if ($column == 'action') {
						$row[$column] = $_buttons;
					} else if ($column == 'selector') {
						$row[$column] = '';
					} else if (in_array($column, array('date_added', 'date_modified'))) {
						// $row[$column] = date($this->language->get('date_format_short'), strtotime($result[$column]));
						$row[$column] = date("Y-d-m", strtotime($result[$column]));
					} else {
						$row[$column] = $result[$column];
					}
				}
			}
			$data['reviews'][] = $row;
		}

		$data['language_id'] = $this->config->get('config_language_id');

		$column_classes = array();
		$type_classes = array();
		$non_sortable = array();

		if (!is_array($columns)) {
			$displayed_columns = array('selector', 'product', 'author', 'rating', 'status', 'date_added', 'action');
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

		$data['update_url'] = html_entity_decode($this->url->link('catalog/review/quick_update', 'token=' . $this->session->data['token'], true));
		$data['refresh_url'] = html_entity_decode($this->url->link('catalog/review/refresh_data', 'token=' . $this->session->data['token'], true));
		$data['load_popup_url'] = html_entity_decode($this->url->link('catalog/review/load_popup', 'token=' . $this->session->data['token'], true));

		$data['status_select'] = addslashes(json_encode(array(array("id" => "0", "value" => $this->language->get('text_disabled')), array("id" => "1", "value" => $this->language->get('text_enabled')))));

		$data['batch_edit'] = (int)$this->config->get('aqe_batch_edit');

		$data['token'] = $this->session->data['token'];

		$url = '';

		foreach ($this->config->get('aqe_catalog_reviews') as $column => $attr) {
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
		foreach ($this->config->get('aqe_catalog_reviews') as $column => $attr) {
			$data['sorts'][$column] = $this->url->link('catalog/review', 'token=' . $this->session->data['token'] . '&sort=' . $attr['sort'] . $url, true);
		}

		$url = '';

		foreach ($this->config->get('aqe_catalog_reviews') as $column => $attr) {
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
		$pagination->total = $review_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/review', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($review_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($review_total - $this->config->get('config_limit_admin'))) ? $review_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $review_total, ceil($review_total / $this->config->get('config_limit_admin')));

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
			$template = 'catalog/aqe/review_list';
		} else {
			$template = 'catalog/aqe/review_list.tpl';
		}

		$this->response->setOutput($this->load->view($template, $data));
	}

	public function autocomplete() {
		$response = array();

		if (isset($this->request->get['filter_product'])) {
			$filter_types = array('product');
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

			$results = $this->model_catalog_aqe_review->getReviews($filter_data);

			foreach ($results as $result) {
				$response[] = array(
					'review_id'  => $result['review_id'],
					'product_id' => $result['product_id'],
					'product'    => strip_tags(html_entity_decode($result['product'], ENT_QUOTES, 'UTF-8')),
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($response));
	}

	public function refresh_data() {
		$response = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateRefreshData($this->request->post)) {
			$response['values'] = array();

			foreach ($this->request->post['data'] as $column => $reviews) {
				foreach ($reviews as $id) {
					switch ($column) {
						case 'date_modified':
							$review = $this->model_catalog_review->getReview($id);
							// $response['values'][$id][$column] = date($this->language->get('date_format_short'), strtotime($review['date_modified']));
							$response['values'][$id][$column] = date("Y-d-m", strtotime($review['date_modified']));
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

			foreach ((array)$id as $_id) {
				if ($this->model_catalog_aqe_review->quickEditReview($_id, $column, $value, $lang_id, $this->request->post)) {
					$results['done'][] = $_id;
				} else {
					$results['failed'][] = $_id;
				}
			}

			$response['results'] = $results;

			if ($results['done']) {
				$this->alert['success']['update'] = $this->language->get('text_success');
				$response['success'] = 1;

				if (in_array($column, array('rating'))) {
					$response['value'] = (int)$value;
					$response['values']['*'] = $response['value'];
				} else if ($column == 'status') {
					if ((int)$value || !$this->config->get('aqe_highlight_status')) {
						$response['value'] = ((int)$value) ? $this->language->get('text_enabled') : $this->language->get('text_disabled');
					} else {
						$response['value'] = ((int)$value) ? $this->language->get('text_enabled') : '<span style="color:#FF0000;">' . $this->language->get('text_disabled') . '</span>';
					}
					$response['values']['*'] = $response['value'];
				} else if ($column == 'product') {
					$this->load->model('catalog/product');
					$product = $this->model_catalog_product->getProduct($value);
					$response['value'] = $product['name'];
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

		if ($column == "author") {
			if ((utf8_strlen($data['new']) < 3) || (utf8_strlen($data['new']) > 64)) {
				$errors = true;
				$this->alert['error']['text'] = $this->language->get('error_author');
			}
		}

		if ($column == "text") {
			if (utf8_strlen($data['new']) < 1) {
				$errors = true;
				$this->alert['error']['text'] = $this->language->get('error_text');
			}
		}

		if ($column == "rating") {
			if (!isset($data['new']) || $data['new'] < 0 || $data['new'] > 5) {
				$errors = true;
				$this->alert['error']['rating'] = $this->language->get('error_rating');
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
		if (!$this->user->hasPermission('modify', 'catalog/review')) {
			$this->alert['error']['permission'] = $this->language->get('error_permission');
			return false;
		} else {
			return true;
		}
	}
}
