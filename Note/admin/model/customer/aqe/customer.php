<?php
class ModelCustomerAqeCustomer extends Model {
	protected static $count = 0;

	public function getCustomers($data = array()) {
		if (isset($data['columns'])) {
			$columns = $data['columns'];
		} else {
			$columns = array('name', 'email', 'customer_group', 'status', 'ip', 'date_added');
		}

		$sql = "SELECT SQL_CALC_FOUND_ROWS c.*, CONCAT(c.firstname, ' ', c.lastname) AS name";

		if (in_array("customer_group", $columns)) {
			$sql .= ", cgd.name AS customer_group";
		}

		$sql .= " FROM `" . DB_PREFIX . "customer` c";

		if (in_array("customer_group", $columns)) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id AND cgd.language_id = '" . (int)$this->config->get('config_language_id') . "')";
		}

		$where = array();

		$int_filters = array(
			'id'                => 'c.customer_id',
			'customer_group'    => 'c.customer_group_id',
			'newsletter'        => 'c.newsletter',
			'approved'          => 'c.approved',
			'safe'              => 'c.safe',
			'status'            => 'c.status',
		);

		foreach ($int_filters as $key => $value) {
			if (isset($data["filter_$key"]) && !is_null($data["filter_$key"])) {
				$where[] = "$value = '" . (int)$data["filter_$key"] . "'";
			}
		}

		$date_filters = array(
			'date_added'        => 'c.date_added',
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

		$anywhere_filters = array(
			'email'     => 'c.email',
			'telephone' => 'c.telephone',
			'fax'       => 'c.fax',
			'ip'        => 'c.ip',
			'name'      => "CONCAT(c.firstname, ' ', c.lastname)",
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

		$sql .= " GROUP BY c.customer_id";

		$sort_data = array(
			'c.customer_id',
			'name',
			'c.email',
			'c.telephone',
			'c.fax',
			'c.newsletter',
			'customer_group',
			'c.status',
			'c.approved',
			'c.safe',
			'c.ip',
			'c.date_added',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
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

	public function getTotalCustomers() {
		return $this->count;
	}

	public function quickEditCustomer($customer_id, $column, $value, $lang_id=null, $data=null) {
		$editable = array('name', 'email', 'telephone', 'fax', 'newsletter', 'customer_group', 'approved', 'safe', 'status');
		$result = false;
		if (in_array($column, $editable)) {
			if (in_array($column, array('email', 'telephone', 'fax')))
				$result = $this->db->query("UPDATE `" . DB_PREFIX . "customer` SET " . $column . " = '" . $this->db->escape($value) . "' WHERE customer_id = '" . (int)$customer_id . "'");
			else if (in_array($column, array('newsletter', 'approved', 'safe', 'status')))
				$result = $this->db->query("UPDATE `" . DB_PREFIX . "customer` SET " . $column . " = '" . (int)$value . "' WHERE customer_id = '" . (int)$customer_id . "'");
			else if (in_array($column, array('customer_group')))
				$result = $this->db->query("UPDATE `" . DB_PREFIX . "customer` SET " . $column . "_id = '" . (int)$value . "' WHERE customer_id = '" . (int)$customer_id . "'");
			else if ($column == "name") {
				$first_name = $data['first_name'];
				$last_name = $data['last_name'];
				$result = $this->db->query("UPDATE `" . DB_PREFIX . "customer` SET firstname = '" . $this->db->escape($first_name) . "', lastname = '" . $this->db->escape($last_name) . "' WHERE customer_id = '" . (int)$customer_id . "'");
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
