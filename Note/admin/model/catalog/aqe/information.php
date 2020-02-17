<?php
class ModelCatalogAqeInformation extends Model {
	protected static $count = 0;

	public function getInformations($data = array()) {
		if (isset($data['columns'])) {
			$columns = $data['columns'];
		} else {
			$columns = array('title', 'sort_order');
		}

		$sql = "SELECT SQL_CALC_FOUND_ROWS i.*, id.*";

		if (in_array("seo", $columns)) {
			$multilingual_seo = $this->config->get('aqe_multilingual_seo');
			if ($multilingual_seo) {
				$sql .= ", (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('information_id=', i.information_id) AND (" . $this->db->escape($multilingual_seo) . " IS NULL OR " . $this->db->escape($multilingual_seo) . " = '" . (int)$this->config->get('config_language_id') . "') ORDER BY " . $this->db->escape($multilingual_seo) . " DESC LIMIT 1) AS seo";
			} else {
				$sql .= ", (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('information_id=', i.information_id) LIMIT 1) AS seo";
			}
		}

		$sql .= " FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id AND id.language_id = '" . (int)$this->config->get('config_language_id') . "')";

		if (isset($data['filter_store'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "information_to_store i2s ON (i.information_id = i2s.information_id)";
		}

		$where = array();

		$int_filters = array(
			'id'                => 'i.information_id',
			'bottom'            => 'i.bottom',
			'status'            => 'i.status',
		);

		foreach ($int_filters as $key => $value) {
			if (isset($data["filter_$key"]) && !is_null($data["filter_$key"])) {
				$where[] = "$value = '" . (int)$data["filter_$key"] . "'";
			}
		}

		$int_interval_filters = array(
			'sort_order'    => 'i.sort_order',
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
			'title'     => "id.title",
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
				$where[] = "(SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('information_id=', i.information_id)) LIKE '%" . $this->db->escape($data['filter_seo']) . "%'";
			} else {
				$where[] = "(SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('information_id=', i.information_id)) LIKE '" . $this->db->escape($data['filter_seo']) . "%'";
			}
		}

		if (isset($data['filter_store'])) {
			if ($data['filter_store'] == '*')
				$where[] = "i2s.store_id IS NULL";
			else
				$where[] = "i2s.store_id = '" . (int)$data['filter_store'] . "'";
		}

		if ($where) {
			$sql .= " WHERE " . implode($where, " AND ");
		}

		$sql .= " GROUP BY i.information_id";

		$sort_data = array(
			'i.information_id',
			'i.bottom',
			'id.title',
			'seo',
			'i.status',
			'i.sort_order',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY id.title";
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

	public function getTotalInformations() {
		return $this->count;
	}

	public function getInformationSeoKeywords($information_id) {
		$data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('information_id=', '" . (int)$information_id . "')");

		$multilingual_seo = $this->config->get('aqe_multilingual_seo');

		foreach ($query->rows as $result) {
			$lang = isset($result[$multilingual_seo]) ? $result[$multilingual_seo] : (isset($result['language_id']) ? $result['language_id'] : null);
			if ($lang) {
				$data[$lang] = $result['keyword'];
			}
		}

		return $data;
	}

	public function quickEditInformation($information_id, $column, $value, $lang_id=null, $data=null) {
		$editable = array('bottom', 'status', 'sort_order');
		$result = false;
		if (in_array($column, $editable)) {
			$result = $this->db->query("UPDATE " . DB_PREFIX . "information SET `" . $column . "` = '" . (int)$value . "' WHERE information_id = '" . (int)$information_id . "'");
		} else if ($column == 'seo') {
			$multilingual_seo = $this->config->get('aqe_multilingual_seo');

			$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'information_id=" . (int)$information_id. "'");

			if (isset($data['value']) && is_array($data['value']) && $multilingual_seo) {
				foreach ((array)$data['value'] as $language_id => $value) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'information_id=" . (int)$information_id . "', keyword = '" . $this->db->escape($value) . "', " . $this->db->escape($multilingual_seo) . " = '" . (int)$language_id . "'");
				}
				$result = 1;
			} else if (!empty($value)) {
				$result = $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'information_id=" . (int)$information_id . "', keyword = '" . $this->db->escape($value) . "'");
			} else {
				$result = 1;
			}
		} else if (in_array($column, array('title'))) {
			if (isset($data['value']) && is_array($data['value'])) {
				foreach ((array)$data['value'] as $language_id => $value) {
					$this->db->query("UPDATE " . DB_PREFIX . "information_description SET " . $column . " = '" . $this->db->escape($value) . "' WHERE information_id = '" . (int)$information_id . "' AND language_id = '" . (int)$language_id . "'");
				}
				$result = 1;
			} else if ($value) {
				$result = $this->db->query("UPDATE " . DB_PREFIX . "information_description SET " . $column . " = '" . $this->db->escape($value) . "' WHERE information_id = '" . (int)$information_id . "' AND language_id = '" . (int)$lang_id . "'");
				$result = 1;
			} else {
				$result = 0;
			}
		} else if ($column == 'store') {
			$this->db->query("DELETE FROM " . DB_PREFIX . "information_to_store WHERE information_id = '" . (int)$information_id . "'");

			if (isset($data['i_s'])) {
				foreach ((array)$data['i_s'] as $store_id) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "information_to_store SET information_id = '" . (int)$information_id . "', store_id = '" . (int)$store_id . "'");
				}
			}
			$result = 1;
		} else if ($column == 'descriptions') {
			foreach ((array)$data['description'] as $language_id => $value) {
				$this->db->query("UPDATE " . DB_PREFIX . "information_description SET description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "' WHERE information_id = '" . (int)$information_id . "' AND language_id = '" . (int)$language_id . "'");
			}
			$result = 1;
		}

		$this->cache->delete('information');

		return $result;
	}

	public function urlAliasExists($information_id, $keyword, $lang_id=null) {
		if (!$keyword) return false;

		$multilingual_seo = $this->config->get('aqe_multilingual_seo');
		if ($lang_id && $multilingual_seo) {
			$query = $this->db->query("SELECT 1 FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($keyword) . "' AND query <> 'information_id=" . (int)$information_id . "'");
			//$query = $this->db->query("SELECT 1 FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($keyword) . "' AND " . $this->db->escape($multilingual_seo) . " = '" . (int)$lang_id . "' AND query <> 'information_id=" . (int)$information_id . "'");
		} else {
			$query = $this->db->query("SELECT 1 FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($keyword) . "' AND query <> 'information_id=" . (int)$information_id . "'");
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
