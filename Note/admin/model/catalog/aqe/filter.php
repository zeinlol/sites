<?php
class ModelCatalogAqeFilter extends Model {
	protected static $count = 0;

	public function getFilterGroups($data = array()) {
		if (isset($data['columns'])) {
			$columns = $data['columns'];
		} else {
			$columns = array('group_name', 'sort_order');
		}

		$sql = "SELECT SQL_CALC_FOUND_ROWS fg.*, fgd.name AS group_name";

		if (in_array("filter", $columns)) {
			$sql .= ", GROUP_CONCAT(f.filter_id ORDER BY f.sort_order SEPARATOR '_') AS filter_ids, GROUP_CONCAT(fd.name ORDER BY f.sort_order SEPARATOR '<br/>') AS filter_names";
		}

		$sql .= " FROM " . DB_PREFIX . "filter_group fg LEFT JOIN " . DB_PREFIX . "filter_group_description fgd ON (fg.filter_group_id = fgd.filter_group_id AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "')";

		if (in_array("filter", $columns)) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "filter f ON (f.filter_group_id = fg.filter_group_id) LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "')";
		}

		$where = array();

		$int_filters = array(
			'id'                => 'fg.filter_group_id',
		);

		foreach ($int_filters as $key => $value) {
			if (isset($data["filter_$key"]) && !is_null($data["filter_$key"])) {
				$where[] = "$value = '" . (int)$data["filter_$key"] . "'";
			}
		}

		$int_interval_filters = array(
			'sort_order'    => 'fg.sort_order',
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
			'group_name'=> 'fgd.name',
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

		if ($where) {
			$sql .= " WHERE " . implode($where, " AND ");
		}

		$sql .= " GROUP BY fg.filter_group_id";

		$having = array();

		$anywhere_filters = array(
			'filter'    => 'filter_names',
		);

		foreach ($anywhere_filters as $key => $value) {
			if (!empty($data["filter_$key"])) {
				if ($this->config->get('aqe_match_anywhere')) {
					$having[] = "$value LIKE '%" . $this->db->escape($data["filter_$key"]) . "%'";
				} else {
					$having[] = "$value LIKE '" . $this->db->escape($data["filter_$key"]) . "%'";
				}
			}
		}

		if ($having) {
			$sql .= " HAVING " . implode($having, " AND ");
		}

		$sort_data = array(
			'fgd.name',
			'fg.filter_group_id',
			'fg.sort_order',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY fgd.name";
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

	public function getTotalFilterGroups() {
		return $this->count;
	}

	public function getFiltersByFilterGroupId($filter_group_id) {
		$query = $this->db->query("SELECT f.*, fd.*, fgd.name AS `group` FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id) LEFT JOIN " . DB_PREFIX . "filter_group_description fgd ON (f.filter_group_id = fgd.filter_group_id) WHERE fd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND f.filter_group_id = '" . (int)$filter_group_id . "' ORDER BY f.sort_order ASC, fd.name ASC");

		return $query->rows;
	}

	public function quickEditFilter($filter_group_id, $column, $value, $lang_id=null, $data=null) {
		$editable = array('sort_order');
		$result = false;
		if (in_array($column, $editable)) {
			$result = $this->db->query("UPDATE " . DB_PREFIX . "filter_group SET " . $column . " = '" . (int)$value . "' WHERE filter_group_id = '" . (int)$filter_group_id . "'");
		} else if (in_array($column, array('group_name'))) {
			if (isset($data['value']) && is_array($data['value'])) {
				foreach ((array)$data['value'] as $language_id => $value) {
					$this->db->query("UPDATE " . DB_PREFIX . "filter_group_description SET name = '" . $this->db->escape($value) . "' WHERE filter_group_id = '" . (int)$filter_group_id . "' AND language_id = '" . (int)$language_id . "'");
				}
				$result = 1;
			} else if ($value) {
				$result = $this->db->query("UPDATE " . DB_PREFIX . "filter_group_description SET name = '" . $this->db->escape($value) . "' WHERE filter_group_id = '" . (int)$filter_group_id . "' AND language_id = '" . (int)$lang_id . "'");
				$result = 1;
			} else {
				$result = 0;
			}
		} else if (in_array($column, array('filter', 'filters'))) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "filter WHERE filter_group_id = '" . (int)$filter_group_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "filter_description WHERE filter_group_id = '" . (int)$filter_group_id . "'");

			if (isset($data['filter'])) {
				foreach ($data['filter'] as $filter) {
					if ($filter['filter_id']) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "filter SET filter_id = '" . (int)$filter['filter_id'] . "', filter_group_id = '" . (int)$filter_group_id . "', sort_order = '" . (int)$filter['sort_order'] . "'");
					} else {
						$this->db->query("INSERT INTO " . DB_PREFIX . "filter SET filter_group_id = '" . (int)$filter_group_id . "', sort_order = '" . (int)$filter['sort_order'] . "'");
					}

					$filter_id = $this->db->getLastId();

					foreach ($filter['filter_description'] as $language_id => $filter_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "filter_description SET filter_id = '" . (int)$filter_id . "', language_id = '" . (int)$language_id . "', filter_group_id = '" . (int)$filter_group_id . "', name = '" . $this->db->escape($filter_description['name']) . "'");
					}
				}
			}
			$result = 1;
		}

		return $result;
	}

	public function getFiltersByGroup() {
		$sql = "SELECT fg.filter_group_id, fgd.name AS group_name, f.filter_id, fd.name AS filter_name FROM " . DB_PREFIX . "filter_group fg LEFT JOIN " . DB_PREFIX . "filter_group_description fgd ON (fg.filter_group_id = fgd.filter_group_id AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "') LEFT JOIN " . DB_PREFIX . "filter f ON (fg.filter_group_id = f.filter_group_id) LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "') ORDER BY fg.sort_order ASC, f.sort_order ASC";

		$query = $this->db->query($sql);

		$data = array();

		$current_group = null;
		$idx = -1;

		foreach($query->rows as $row) {
			if (is_null($current_group) || $current_group != $row['filter_group_id']) {
				$data[++$idx] = array(
					'filter_group_id'   => $row['filter_group_id'],
					'name'              => $row['group_name'],
					'filters'           => array()
				);
				$current_group = $row['filter_group_id'];
			}

			$data[$idx]['filters'][] = array(
				'filter_id' => $row['filter_id'],
				'name'      => $row['filter_name']
			);
		}

		return $data;
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
