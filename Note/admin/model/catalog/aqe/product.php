<?php
class ModelCatalogAqeProduct extends Model {
	protected static $productCount = 0;

	public function getProducts($data = array()) {
		if (isset($data['columns'])) {
			$columns = $data['columns'];
		} else {
			$columns = array('image', 'name', 'model', 'price', 'quantity', 'status');
		}

		$sql = "SELECT SQL_CALC_FOUND_ROWS p.*, pd.*";

		if (in_array("seo", $columns)) {
			$multilingual_seo = $this->config->get('aqe_multilingual_seo');
			if ($multilingual_seo) {
				$sql .= ", (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('product_id=', p.product_id) AND (" . $this->db->escape($multilingual_seo) . " IS NULL OR " . $this->db->escape($multilingual_seo) . " = '" . (int)$this->config->get('config_language_id') . "') ORDER BY " . $this->db->escape($multilingual_seo) . " DESC LIMIT 1) AS seo";
			} else {
				$sql .= ", (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('product_id=', p.product_id) LIMIT 1) AS seo";
			}
		}

		if (in_array("manufacturer", $columns)) {
			$sql .= ", m.name AS manufacturer";
		}

		if (in_array("tax_class", $columns)) {
			$sql .= ", tc.title AS tax_class";
		}

		if (in_array("stock_status", $columns)) {
			$sql .= ", ss.name AS stock_status";
		}

		if (in_array("length_class", $columns)) {
			$sql .= ", lcd.title AS length_class";
		}

		if (in_array("weight_class", $columns)) {
			$sql .= ", wcd.title AS weight_class";
		}

		$sql .= " FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "')";

		if (!empty($data['filter_special_price']) && in_array($data['filter_special_price'], array("active", "expired", "future"))) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_special ps ON (ps.product_id = p.product_id)";
		}

		if (in_array("manufacturer", $columns)) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "manufacturer m ON (m.manufacturer_id = p.manufacturer_id)";
		}

		if (isset($data['filter_filter'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_filter p2f ON (p.product_id = p2f.product_id) LEFT JOIN " . DB_PREFIX . "filter_description fd ON (fd.filter_id = p2f.filter_id AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "')";
		}

		if (isset($data['filter_download'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_download p2d ON (p.product_id = p2d.product_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (dd.download_id = p2d.download_id AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "')";
		}

		if (in_array("tax_class", $columns)) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "tax_class tc ON (tc.tax_class_id = p.tax_class_id)";
		}

		if (in_array("stock_status", $columns)) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "stock_status ss ON (ss.stock_status_id = p.stock_status_id)";
		}

		if (in_array("length_class", $columns)) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "length_class lc ON (lc.length_class_id = p.length_class_id) LEFT JOIN " . DB_PREFIX . "length_class_description lcd ON (lcd.length_class_id = lc.length_class_id AND lcd.language_id = '" . (int)$this->config->get('config_language_id') . "')";
		}

		if (in_array("weight_class", $columns)) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "weight_class wc ON (wc.weight_class_id = p.weight_class_id) LEFT JOIN " . DB_PREFIX . "weight_class_description wcd ON (wcd.weight_class_id = wc.weight_class_id AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "')";
		}

		if (!empty($data['filter_category'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";
		}

		if (isset($data['filter_store'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)";
		}

		$where = array();

		$int_filters = array(
			'tax_class'         => 'p.tax_class_id',
			'length_class'      => 'p.length_class_id',
			'weight_class'      => 'p.weight_class_id',
			'manufacturer'      => 'p.manufacturer_id',
			'stock_status'      => 'p.stock_status_id',
			'subtract'          => 'p.subtract',
			'id'                => 'p.product_id',
			'status'            => 'p.status',
			'requires_shipping' => 'p.shipping',
		);

		foreach ($int_filters as $key => $value) {
			if (isset($data["filter_$key"]) && !is_null($data["filter_$key"])) {
				$where[] = "$value = '" . (int)$data["filter_$key"] . "'";
			}
		}

		$date_filters = array(
			'date_added'        => 'p.date_added',
			'date_available'    => 'p.date_available',
			'date_modified'     => 'p.date_modified',
		);

		foreach ($date_filters as $key => $value) {
			if (isset($data["filter_$key"]) && !is_null($data["filter_$key"])) {
				if ($this->config->get('aqe_interval_filter')) {
					$where[] = $this->filterInterval($this->db->escape($data["filter_$key"]), $value, true);
				} else {
					$where[] = "DATE($value) = DATE('" . $this->db->escape($data["filter_$key"]) . "')";
				}
			}
		}

		$float_interval_filters = array(
			'length'    => 'p.length',
			'width'     => 'p.width',
			'height'    => 'p.height',
			'weight'    => 'p.weight',
			'price'     => 'p.price',
		);

		foreach ($float_interval_filters as $key => $value) {
			if ($key == "price" && !empty($data['filter_special_price']) && in_array($data['filter_special_price'], array("active", "expired", "future"))) {
				if ($data['filter_special_price'] == "active") {
					$where[] = "((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))";
				} elseif ($data['filter_special_price'] == "expired") {
					$where[] = "(ps.date_end != '0000-00-00' AND ps.date_end < NOW())";
				} elseif ($data['filter_special_price'] == "future") {
					$where[] = "(ps.date_start > NOW() AND ps.date_start != '0000-00-00')";
				}
			} else {
				if (isset($data["filter_$key"]) && !is_null($data["filter_$key"])) {
					if ($this->config->get('aqe_interval_filter')) {
						$where[] = $this->filterInterval($data["filter_$key"], $value);
					} else {
						$where[] = "$value = '" . $this->db->escape($data["filter_$key"]) . "%'";
					}
				}
			}
		}

		$int_interval_filters = array(
			'quantity'      => 'p.quantity',
			'minimum'       => 'p.minimum',
			'points'        => 'p.points',
			'sort_order'    => 'p.sort_order',
		);

		foreach ($int_interval_filters as $key => $value) {
			if (isset($data["filter_$key"]) && !is_null($data["filter_$key"])) {
				if ($this->config->get('aqe_interval_filter')) {
					$where[] = $this->filterInterval($data["filter_$key"], $value);
				} else {
					$where[] = "$value = '" . (int)$data["filter_$key"] . "'";
				}
			}
		}

		$anywhere_filters = array(
			'sku'       => 'p.sku',
			'upc'       => 'p.upc',
			'ean'       => 'p.ean',
			'jan'       => 'p.jan',
			'isbn'      => 'p.isbn',
			'mpn'       => 'p.mpn',
			'location'  => 'p.location',
			'name'      => 'pd.name',
			'model'     => 'p.model',
		);

		foreach ($anywhere_filters as $key => $value) {
			if (!empty($data["filter_$key"])) {
				if ($this->config->get('aqe_match_anywhere')) {
					$where[] = "$value LIKE '%" . $this->db->escape($data["filter_$key"]) . "%'";
				} else {
					$where[] = "$value LIKE '" . $this->db->escape($data["filter_$key"]) . "%'";
				}
			}
		}

		if (!empty($data['filter_seo'])) {
			if ($this->config->get('aqe_match_anywhere')) {
				$where[] = "(SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('product_id=', p.product_id)) LIKE '%" . $this->db->escape($data['filter_seo']) . "%'";
			} else {
				$where[] = "(SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('product_id=', p.product_id)) LIKE '" . $this->db->escape($data['filter_seo']) . "%'";
			}
		}

		if (!empty($data['filter_tag'])) {
			$where[] = "pd.tag LIKE '%" . $this->db->escape($data['filter_tag']) . "%'";
		}

		if (isset($data['filter_store'])) {
			if ($data['filter_store'] == '*')
				$where[] = "p2s.store_id IS NULL";
			else
				$where[] = "p2s.store_id = '" . (int)$data['filter_store'] . "'";
		}

		if (isset($data['filter_filter'])) {
			if ($data['filter_filter'] == '*')
				$where[] = "p2f.filter_id IS NULL";
			else
				$where[] = "p2f.filter_id = '" . (int)$data['filter_filter'] . "'";
		}

		if (isset($data['filter_download'])) {
			if ($data['filter_download'] == '*')
				$where[] = "p2d.download_id IS NULL";
			else
				$where[] = "p2d.download_id = '" . (int)$data['filter_download'] . "'";
		}

		if (!empty($data['filter_category'])) {
			if (!empty($data['filter_sub_category'])) {
				$implode_data = array();

				if ($data['filter_category'] == '*')
					$implode_data[] = "p2c.category_id IS NULL";
				else
					$implode_data[] = "p2c.category_id = '" . (int)$data['filter_category'] . "'";

				$categories = $this->getSubCategories($data['filter_category']);

				foreach ($categories as $category) {
					if ($data['filter_category'] != '*')
						$implode_data[] = "p2c.category_id = '" . (int)$category['category_id'] . "'";
				}

				$where[] = "(" . implode(' OR ', $implode_data) . ")";
			} else {
				if ($data['filter_category'] == '*')
					$where[] = "p2c.category_id IS NULL";
				else
					$where[] = "p2c.category_id = '" . (int)$data['filter_category'] . "'";
			}
		}

		if ($where) {
			$sql .= " WHERE " . implode($where, " AND ");
		}

		$sql .= " GROUP BY p.product_id";

		$sort_data = array(
			'p.product_id',
			'tc.title',
			'p.minimum',
			'p.subtract',
			'ss.name',
			'p.shipping',
			'p.date_added',
			'p.date_available',
			'p.date_modified',
			'lc.title',
			'wc.title',
			'p.points',
			'p.length',
			'p.width',
			'p.height',
			'p.weight',
			'p.sku',
			'p.upc',
			'p.ean',
			'p.jan',
			'p.isbn',
			'p.mpn',
			'p.location',
			'm.name',
			'seo',
			'pd.name',
			'p.model',
			'p.price',
			'p.quantity',
			'p.status',
			'p.sort_order',
			'p.viewed'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY pd.name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		$count = $this->db->query("SELECT FOUND_ROWS() AS count");
		$this->productCount = ($count->num_rows) ? (int)$count->row['count'] : 0;

		return $query->rows;
	}

	public function getTotalProducts() {
		return $this->productCount;
	}

	public function getProductSeoKeywords($product_id) {
		$data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('product_id=', '" . (int)$product_id . "')");

		$multilingual_seo = $this->config->get('aqe_multilingual_seo');

		foreach ($query->rows as $result) {
			$lang = isset($result[$multilingual_seo]) ? $result[$multilingual_seo] : (isset($result['language_id']) ? $result['language_id'] : null);
			if ($lang) {
				$data[$lang] = $result['keyword'];
			}
		}

		return $data;
	}

	public function quickEditProduct($product_id, $column, $value, $lang_id=null, $data=null) {
		$editable = array('manufacturer', 'image', 'model', 'sku', 'upc', 'ean', 'jan', 'mpn', 'isbn', 'location', 'quantity', 'price', 'weight', 'status', 'sort_order', 'tax_class', 'minimum', 'subtract', 'stock_status', 'shipping', 'date_available', 'date_added', 'length', 'width', 'height', 'length_class', 'weight_class', 'points', 'viewed');
		$result = false;
		if (in_array($column, $editable)) {
			if (in_array($column, array('image', 'model', 'sku', 'upc', 'ean', 'jan', 'mpn', 'isbn', 'location', 'date_available', 'date_added')))
				$result = $this->db->query("UPDATE " . DB_PREFIX . "product SET " . $column . " = '" . $this->db->escape($value) . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
			else if (in_array($column, array('quantity', 'sort_order', 'status', 'minimum', 'subtract', 'shipping', 'points', 'viewed')))
				$result = $this->db->query("UPDATE " . DB_PREFIX . "product SET " . $column . " = '" . (int)$value . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
			else if (in_array($column, array('manufacturer', 'tax_class', 'stock_status', 'length_class', 'weight_class')))
				$result = $this->db->query("UPDATE " . DB_PREFIX . "product SET " . $column . "_id = '" . (int)$value . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
			else
				$result = $this->db->query("UPDATE " . DB_PREFIX . "product SET " . $column . " = '" . (float)$value . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
		} else if ($column == 'seo') {
			$multilingual_seo = $this->config->get('aqe_multilingual_seo');

			$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id. "'");

			if (isset($data['value']) && is_array($data['value']) && $multilingual_seo) {
				foreach ((array)$data['value'] as $language_id => $value) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($value) . "', " . $this->db->escape($multilingual_seo) . " = '" . (int)$language_id . "'");
				}
				$result = 1;
			} else if (!empty($value)) {
				$result = $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($value) . "'");
			} else {
				$result = 1;
			}
		} else if (in_array($column, array('name', 'tag'))) {
			if (isset($data['value']) && is_array($data['value'])) {
				foreach ((array)$data['value'] as $language_id => $value) {
					$this->db->query("UPDATE " . DB_PREFIX . "product_description SET " . $column . " = '" . $this->db->escape($value) . "' WHERE product_id = '" . (int)$product_id . "' AND language_id = '" . (int)$language_id . "'");
				}
				$result = 1;
			} else if ($value) {
				$result = $this->db->query("UPDATE " . DB_PREFIX . "product_description SET " . $column . " = '" . $this->db->escape($value) . "' WHERE product_id = '" . (int)$product_id . "' AND language_id = '" . (int)$lang_id . "'");
				$result = 1;
			} else {
				$result = 0;
			}
		} else if ($column == 'category') {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

			if (isset($data['p_c'])) {
				foreach ((array)$data['p_c'] as $category_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
				}
			}
			$result = 1;
		} else if ($column == 'store') {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");

			if (isset($data['p_s'])) {
				foreach ((array)$data['p_s'] as $store_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "'");
				}
			}
			$result = 1;
		} else if ($column == 'filter') {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "'");

			if (isset($data['p_f'])) {
				foreach ((array)$data['p_f'] as $filter_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = '" . (int)$filter_id . "'");
				}
			}
			$result = 1;
		} else if ($column == 'download') {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");

			/*if (isset($data['p_d'])) {
				foreach ((array)$data['p_d'] as $download_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");
				}
			}*/
			if (isset($data['product_download'])) {
				foreach ((array)$data['product_download'] as $download_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");
				}
			}
			$result = 1;
		} else if ($column == 'attributes') {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");

			if (!empty($data['product_attribute'])) {
				foreach ((array)$data['product_attribute'] as $product_attribute) {
					if ($product_attribute['attribute_id']) {
						$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "'");

						foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($product_attribute_description['text']) . "'");
						}
					}
				}
			}
			$result = 1;
		} else if ($column == 'discounts') {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");

			if (isset($data['product_discount'])) {
				foreach ((array)$data['product_discount'] as $product_discount) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "', price = '" . (float)$product_discount['price'] . "', date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
				}
			}
			$result = 1;
		} else if ($column == 'images') {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");

			if (isset($data['product_image'])) {
				foreach ((array)$data['product_image'] as $product_image) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($product_image['image'], ENT_QUOTES, 'UTF-8')) . "', sort_order = '" . (int)$product_image['sort_order'] . "'");
				}
			}
			$result = 1;
		} else if ($column == 'options') {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");

			if (isset($data['product_option'])) {
				foreach ($data['product_option'] as $product_option) {
					if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
						$query = $this->db->query("SELECT 1 FROM " . DB_PREFIX . "product_option WHERE product_option_id = '" . (int)$product_option['product_option_id'] . "'");
						if ($query->num_rows) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', required = '" . (int)$product_option['required'] . "'");
						} else {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', required = '" . (int)$product_option['required'] . "'");
						}

						$product_option_id = $this->db->getLastId();

						if (isset($product_option['product_option_value'])) {
							foreach ((array)$product_option['product_option_value'] as $product_option_value) {
								$query = $this->db->query("SELECT 1 FROM " . DB_PREFIX . "product_option_value WHERE product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "'");
								if ($query->num_rows) {
									$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value_id = '" . (int)$product_option_value['option_value_id'] . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "', points = '" . (int)$product_option_value['points'] . "', points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "', weight = '" . (float)$product_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'");
								} else {
									$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "', product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value_id = '" . (int)$product_option_value['option_value_id'] . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "', points = '" . (int)$product_option_value['points'] . "', points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "', weight = '" . (float)$product_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'");
								}
							}
						}
					} else {
						$query = $this->db->query("SELECT 1 FROM " . DB_PREFIX . "product_option WHERE product_option_id = '" . (int)$product_option['product_option_id'] . "'");
						if ($query->num_rows) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', value = '" . $this->db->escape($product_option['value']) . "', required = '" . (int)$product_option['required'] . "'");
						} else {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', value = '" . $this->db->escape($product_option['value']) . "', required = '" . (int)$product_option['required'] . "'");
						}
					}
				}
			}
			$result = 1;
		} else if ($column == 'recurrings') {
			$this->db->query("DELETE FROM `" . DB_PREFIX . "product_recurring` WHERE product_id = " . (int)$product_id);

			if (isset($data['product_recurrings'])) {
				foreach ($data['product_recurrings'] as $recurring) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "product_recurring` SET `product_id` = " . (int)$product_id . ", customer_group_id = " . (int)$recurring['customer_group_id'] . ", `recurring_id` = " . (int)$recurring['recurring_id']);
				}
			}
			$result = 1;
		} else if ($column == 'specials') {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");

			if (isset($data['product_special'])) {
				foreach ((array)$data['product_special'] as $product_special) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_special['customer_group_id'] . "', priority = '" . (int)$product_special['priority'] . "', price = '" . (float)$product_special['price'] . "', date_start = '" . $this->db->escape($product_special['date_start']) . "', date_end = '" . $this->db->escape($product_special['date_end']) . "'");
				}
			}
			$result = 1;
		} else if ($column == 'filters') {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "'");

			if (isset($data['product_filters'])) {
				foreach ((array)$data['product_filters'] as $filter_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = '" . (int)$filter_id . "'");
				}
			}
			$result = 1;
		} else if ($column == 'related') {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int)$product_id . "'");

			if (isset($data['product_related'])) {
				foreach ((array)$data['product_related'] as $related_id) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
					$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'");
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'");
				}
			}
			$result = 1;
		} else if ($column == 'descriptions') {
			foreach ((array)$data['product_description'] as $language_id => $value) {
				$this->db->query("UPDATE " . DB_PREFIX . "product_description SET description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "' WHERE product_id = '" . (int)$product_id . "' AND language_id = '" . (int)$language_id . "'");
			}
			$result = 1;
		}

		$this->cache->delete('product');

		return $result;
	}

	public function urlAliasExists($product_id, $keyword, $lang_id=null) {
		if (!$keyword) return false;

		$multilingual_seo = $this->config->get('aqe_multilingual_seo');
		if ($lang_id && $multilingual_seo) {
			$query = $this->db->query("SELECT 1 FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($keyword) . "' AND query <> 'product_id=" . (int)$product_id . "'");
			//$query = $this->db->query("SELECT 1 FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($keyword) . "' AND " . $this->db->escape($multilingual_seo) . " = '" . (int)$lang_id . "' AND query <> 'product_id=" . (int)$product_id . "'");
		} else {
			$query = $this->db->query("SELECT 1 FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($keyword) . "' AND query <> 'product_id=" . (int)$product_id . "'");
		}

		if ($query->row) {
			return true;
		} else {
			return false;
		}
	}

	public function filterInterval($filter, $field, $date=false) {
		if ($date) {
			if (preg_match('/^(!=|<>)\s*(\d{2,4}-\d{1,2}-\d{1,2})$/', html_entity_decode(trim($filter)), $matches) && count($matches) == 3) {
				return "DATE($field) <> DATE('" . $matches[2] . "')";
			} else if (preg_match('/^(\d{2,4}-\d{1,2}-\d{1,2})\s*(<|<=)\s*(\d{2,4}-\d{1,2}-\d{1,2})$/', html_entity_decode(trim($filter)), $matches) && count($matches) == 4 && strtotime($matches[1]) <= strtotime($matches[3])) {
				return "DATE('" . $matches[1] . "') ${matches[2]} DATE($field) AND DATE($field) ${matches[2]} DATE('" . $matches[3] . "')";
			} else if (preg_match('/^(\d{2,4}-\d{1,2}-\d{1,2})\s*(>|>=)\s*(\d{2,4}-\d{1,2}-\d{1,2})$/', html_entity_decode(trim($filter)), $matches) && count($matches) == 4 && strtotime($matches[1]) >= strtotime($matches[3])) {
				return "DATE('" . $matches[1] . "') ${matches[2]} DATE($field) AND DATE($field) ${matches[2]} DATE('" . $matches[3] . "')";
			} else if (preg_match('/^(<|<=|>|>=)\s*(\d{2,4}-\d{1,2}-\d{1,2})$/', html_entity_decode(trim($filter)), $matches) && count($matches) == 3) {
				return "DATE($field) ${matches[1]} DATE('" . $matches[2] . "')";
			} else if (preg_match('/^(\d{2,4}-\d{1,2}-\d{1,2})\s*(>|>=|<|<=)$/', html_entity_decode(trim($filter)), $matches) && count($matches) == 3) {
				return "DATE('" . $matches[1] . "') ${matches[2]} DATE($field)";
			} else {
				return "DATE(${field}) = DATE('${filter}')";
			}
		} else {
			if (preg_match('/^(!=|<>)\s*(-?\d+\.?\d*)$/', html_entity_decode(trim(str_replace(",", ".", $filter))), $matches) && count($matches) == 3) {
				return "$field <> '" . (float)$matches[2] . "'";
			} else if (preg_match('/^(-?\d+\.?\d*)\s*(<|<=)\s*(-?\d+\.?\d*)$/', html_entity_decode(trim(str_replace(",", ".", $filter))), $matches) && count($matches) == 4 && (float)$matches[1] <= (float)$matches[3]) {
				return "'" . (float)$matches[1] . "' ${matches[2]} $field AND $field ${matches[2]} '" . (float)$matches[3] . "'";
			} else if (preg_match('/^(-?\d+\.?\d*)\s*(>|>=)\s*(-?\d+\.?\d*)$/', html_entity_decode(trim(str_replace(",", ".", $filter))), $matches) && count($matches) == 4 && (float)$matches[1] >= (float)$matches[3]) {
				return "'" . (float)$matches[1] . "' ${matches[2]} $field AND $field ${matches[2]} '" . (float)$matches[3] . "'";
			} else if (preg_match('/^(<|<=|>|>=)\s*(-?\d+\.?\d*)$/', html_entity_decode(trim(str_replace(",", ".", $filter))), $matches) && count($matches) == 3) {
				return "$field ${matches[1]} '" . (float)$matches[2] . "'";
			} else if (preg_match('/^(-?\d+\.?\d*)\s*(>|>=|<|<=)$/', html_entity_decode(trim(str_replace(",", ".", $filter))), $matches) && count($matches) == 3) {
				return "'" . (float)$matches[1] . "' ${matches[2]} $field";
			} else {
				return $field . " = '" . $this->db->escape($filter) . "'";
			}
		}
	}

	public function getSubCategories($category_id) {
		$sql = "SELECT DISTINCT category_id FROM " . DB_PREFIX . "category_path WHERE path_id = '" . (int)$category_id . "'";

		$query = $this->db->query($sql);

		return $query->rows;
	}
}
