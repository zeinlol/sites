<?php
class ModelCatalogAqeRecurring extends Model {
	protected static $count = 0;

	public function getRecurrings($data = array()) {
		if (isset($data['columns'])) {
			$columns = $data['columns'];
		} else {
			$columns = array('name', 'sort_order');
		}

		$sql = "SELECT SQL_CALC_FOUND_ROWS r.*, rd.*";

		$sql .= " FROM " . DB_PREFIX . "recurring r LEFT JOIN " . DB_PREFIX . "recurring_description rd ON (r.recurring_id = rd.recurring_id AND rd.language_id = '" . (int)$this->config->get('config_language_id') . "')";

		$where = array();

		$int_filters = array(
			'id'                => 'r.recurring_id',
			'status'            => 'r.status',
			'trial_status'      => 'r.trial_status',
		);

		foreach ($int_filters as $key => $value) {
			if (isset($data["filter_$key"]) && !is_null($data["filter_$key"])) {
				$where[] = "$value = '" . (int)$data["filter_$key"] . "'";
			}
		}

		$exact_filters = array(
			'frequency'         => 'r.frequency',
			'trial_frequency'   => 'r.trial_frequency',
		);

		foreach ($exact_filters as $key => $value) {
			if (isset($data["filter_$key"]) && !is_null($data["filter_$key"])) {
				$where[] = "$value = '" . $this->db->escape($data["filter_$key"]) . "'";
			}
		}

		$float_interval_filters = array(
			'price'         => 'r.price',
			'trial_price'   => 'r.trial_price',
		);

		foreach ($float_interval_filters as $key => $value) {
			if (isset($data["filter_$key"]) && !is_null($data["filter_$key"])) {
				if ($this->config->get('aqe_interval_filter')) {
					$where[] = $this->filterInterval($data["filter_$key"], $value);
				} else {
					$where[] = "$value = '" . $this->db->escape($data["filter_$key"]) . "%'";
				}
			}
		}

		$int_interval_filters = array(
			'duration'      => 'r.duration',
			'cycle'         => 'r.cycle',
			'trial_duration'=> 'r.trial_duration',
			'trial_cycle'   => 'r.trial_cycle',
			'sort_order'    => 'r.sort_order',
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
			'name'      => 'rd.name',
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

		$sql .= " GROUP BY r.recurring_id";

		$sort_data = array(
			'r.recurring_id',
			'rd.name',
			'r.price',
			'r.frequency',
			'r.duration',
			'r.cycle',
			'r.trial_status',
			'r.trial_price',
			'r.trial_frequency',
			'r.trial_duration',
			'r.trial_cycle',
			'r.status',
			'r.sort_order',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY rd.name";
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

	public function getTotalRecurrings() {
		return $this->count;
	}

	public function quickEditRecurring($recurring_id, $column, $value, $lang_id=null, $data=null) {
		$editable = array('frequency', 'trial_frequency', 'sort_order', 'status', 'duration', 'cycle', 'trial_status', 'trial_duration', 'trial_cycle', 'price', 'trial_price');
		$result = false;
		if (in_array($column, $editable)) {
			if (in_array($column, array('frequency', 'trial_frequency')))
				$result = $this->db->query("UPDATE " . DB_PREFIX . "recurring SET " . $column . " = '" . $this->db->escape($value) . "' WHERE recurring_id = '" . (int)$recurring_id . "'");
			else if (in_array($column, array('sort_order', 'status', 'duration', 'cycle', 'trial_status', 'trial_duration', 'trial_cycle')))
				$result = $this->db->query("UPDATE " . DB_PREFIX . "recurring SET " . $column . " = '" . (int)$value . "' WHERE recurring_id = '" . (int)$recurring_id . "'");
			else
				$result = $this->db->query("UPDATE " . DB_PREFIX . "recurring SET " . $column . " = '" . (float)$value . "' WHERE recurring_id = '" . (int)$recurring_id . "'");
		} else if (in_array($column, array('name'))) {
			if (isset($data['value']) && is_array($data['value'])) {
				foreach ((array)$data['value'] as $language_id => $value) {
					$this->db->query("UPDATE " . DB_PREFIX . "recurring_description SET " . $column . " = '" . $this->db->escape($value) . "' WHERE recurring_id = '" . (int)$recurring_id . "' AND language_id = '" . (int)$language_id . "'");
				}
				$result = 1;
			} else if ($value) {
				$result = $this->db->query("UPDATE " . DB_PREFIX . "recurring_description SET " . $column . " = '" . $this->db->escape($value) . "' WHERE recurring_id = '" . (int)$recurring_id . "' AND language_id = '" . (int)$lang_id . "'");
				$result = 1;
			} else {
				$result = 0;
			}
		}

		return $result;
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
