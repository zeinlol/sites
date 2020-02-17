<?php
class ModelCatalogAqeManufacturer extends Model {
	protected static $count = 0;

	public function getManufacturers($data = array()) {
		if (isset($data['columns'])) {
			$columns = $data['columns'];
		} else {
			$columns = array('name', 'sort_order');
		}

		$sql = "SELECT SQL_CALC_FOUND_ROWS m.*";

		if (in_array("seo", $columns)) {
			$multilingual_seo = $this->config->get('aqe_multilingual_seo');
			if ($multilingual_seo) {
				$sql .= ", (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('manufacturer_id=', m.manufacturer_id) AND (" . $this->db->escape($multilingual_seo) . " IS NULL OR " . $this->db->escape($multilingual_seo) . " = '" . (int)$this->config->get('config_language_id') . "') ORDER BY " . $this->db->escape($multilingual_seo) . " DESC LIMIT 1) AS seo";
			} else {
				$sql .= ", (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('manufacturer_id=', m.manufacturer_id) LIMIT 1) AS seo";
			}
		}

		$sql .= " FROM " . DB_PREFIX . "manufacturer m";

		if (isset($data['filter_store'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id)";
		}

		$where = array();

		$int_filters = array(
			'id'                => 'm.manufacturer_id',
		);

		foreach ($int_filters as $key => $value) {
			if (isset($data["filter_$key"]) && !is_null($data["filter_$key"])) {
				$where[] = "$value = '" . (int)$data["filter_$key"] . "'";
			}
		}

		$int_interval_filters = array(
			'sort_order'    => 'm.sort_order',
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
			'name'      => "m.name",
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
				$where[] = "(SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('manufacturer_id=', m.manufacturer_id)) LIKE '%" . $this->db->escape($data['filter_seo']) . "%'";
			} else {
				$where[] = "(SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('manufacturer_id=', m.manufacturer_id)) LIKE '" . $this->db->escape($data['filter_seo']) . "%'";
			}
		}

		if (isset($data['filter_store'])) {
			if ($data['filter_store'] == '*')
				$where[] = "m2s.store_id IS NULL";
			else
				$where[] = "m2s.store_id = '" . (int)$data['filter_store'] . "'";
		}

		if ($where) {
			$sql .= " WHERE " . implode($where, " AND ");
		}

		$sql .= " GROUP BY m.manufacturer_id";

		$sort_data = array(
			'm.manufacturer_id',
			'm.name',
			'seo',
			'm.sort_order',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY m.name";
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
		$this->count = ($count->num_rows) ? (int)$count->row['count'] : 0;

		return $query->rows;
	}

	public function getTotalManufacturers() {
		return $this->count;
	}

	public function getManufacturerSeoKeywords($manufacturer_id) {
		$data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('manufacturer_id=', '" . (int)$manufacturer_id . "')");

		$multilingual_seo = $this->config->get('aqe_multilingual_seo');

		foreach ($query->rows as $result) {
			$lang = isset($result[$multilingual_seo]) ? $result[$multilingual_seo] : (isset($result['language_id']) ? $result['language_id'] : null);
			if ($lang) {
				$data[$lang] = $result['keyword'];
			}
		}

		return $data;
	}

	public function quickEditManufacturer($manufacturer_id, $column, $value, $lang_id=null, $data=null) {
		$editable = array('image', 'name', 'sort_order');
		$result = false;
		if (in_array($column, $editable)) {
			if (in_array($column, array('sort_order')))
				$result = $this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET `" . $column . "` = '" . (int)$value . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
			else if (in_array($column, array('image', 'name')))
				$result = $this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET `" . $column . "` = '" . $this->db->escape($value) . "' WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		} else if ($column == 'seo') {
			$multilingual_seo = $this->config->get('aqe_multilingual_seo');

			$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'manufacturer_id=" . (int)$manufacturer_id. "'");

			if (isset($data['value']) && is_array($data['value']) && $multilingual_seo) {
				foreach ((array)$data['value'] as $language_id => $value) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'manufacturer_id=" . (int)$manufacturer_id . "', keyword = '" . $this->db->escape($value) . "', " . $this->db->escape($multilingual_seo) . " = '" . (int)$language_id . "'");
				}
				$result = 1;
			} else if (!empty($value)) {
				$result = $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'manufacturer_id=" . (int)$manufacturer_id . "', keyword = '" . $this->db->escape($value) . "'");
			} else {
				$result = 1;
			}
		} else if ($column == 'store') {
			$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturer_to_store WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

			if (isset($data['i_s'])) {
				foreach ((array)$data['i_s'] as $store_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_to_store SET manufacturer_id = '" . (int)$manufacturer_id . "', store_id = '" . (int)$store_id . "'");
				}
			}
			$result = 1;
		}

		$this->cache->delete('manufacturer');

		return $result;
	}

	public function urlAliasExists($manufacturer_id, $keyword, $lang_id=null) {
		if (!$keyword) return false;

		$multilingual_seo = $this->config->get('aqe_multilingual_seo');
		if ($lang_id && $multilingual_seo) {
			$query = $this->db->query("SELECT 1 FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($keyword) . "' AND query <> 'manufacturer_id=" . (int)$manufacturer_id . "'");
			//$query = $this->db->query("SELECT 1 FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($keyword) . "' AND " . $this->db->escape($multilingual_seo) . " = '" . (int)$lang_id . "' AND query <> 'manufacturer_id=" . (int)$manufacturer_id . "'");
		} else {
			$query = $this->db->query("SELECT 1 FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($keyword) . "' AND query <> 'manufacturer_id=" . (int)$manufacturer_id . "'");
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
}
