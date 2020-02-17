<?php
class ModelMarketingAqeAffiliate extends Model {
	protected static $count = 0;

	public function getAffiliates($data = array()) {
		if (isset($data['columns'])) {
			$columns = $data['columns'];
		} else {
			$columns = array('name', 'email', 'balance', 'status', 'date_added');
		}

		$sql = "SELECT SQL_CALC_FOUND_ROWS a.*, CONCAT(a.firstname, ' ', a.lastname) AS name, a.code AS tracking_code";

		if (in_array("balance", $columns)) {
			$sql .= ", IFNULL(SUM(at.amount), 0) AS balance";
		}

		if (in_array("country", $columns)) {
			$sql .= ", c.name AS country";
		}

		if (in_array("region", $columns)) {
			$sql .= ", z.name AS region";
		}

		$sql .= " FROM `" . DB_PREFIX . "affiliate` a";

		if (in_array("balance", $columns)) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "affiliate_transaction at ON (a.affiliate_id = at.affiliate_id)";
		}

		if (in_array("country", $columns) || isset($data['filter_country'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "country c ON (a.country_id = c.country_id)";
		}

		if (in_array("region", $columns) || isset($data['filter_region'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "zone z ON (a.zone_id = z.zone_id)";
		}

		$where = array();

		$int_filters = array(
			'id'                => 'a.affiliate_id',
			'country'   		=> 'a.country_id',
			'approved'          => 'a.approved',
			'status'            => 'a.status',
		);

		foreach ($int_filters as $key => $value) {
			if (isset($data["filter_$key"]) && !is_null($data["filter_$key"])) {
				$where[] = "$value = '" . (int)$data["filter_$key"] . "'";
			}
		}

		$float_interval_filters = array(
			'commission'  => 'a.commission',
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

		$date_filters = array(
			'date_added'        => 'a.date_added',
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
			'email'     => 'a.email',
			'telephone' => 'a.telephone',
			'fax'       => 'a.fax',
			'company'   => 'a.company',
			'address_1' => 'a.address_1',
			'address_2' => 'a.address_2',
			'postcode'  => 'a.postcode',
			'region'    => 'z.name',
			'city'      => 'a.city',
			'tracking_code'=> 'a.code',
			'tax'        => 'a.tax',
			'ip'        => 'a.ip',
			'name'      => "CONCAT(a.firstname, ' ', a.lastname)",
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

		$sql .= " GROUP BY a.affiliate_id";

		$having = array();

		$float_interval_filters = array(
			'balance'  => 'balance',
		);

		foreach ($float_interval_filters as $key => $value) {
			if (isset($data["filter_$key"]) && !is_null($data["filter_$key"])) {
				if ($this->config->get('aqe_interval_filter')) {
					$having[] = $this->filterInterval($data["filter_$key"], $value);
				} else {
					$having[] = "$value = '" . $this->db->escape($data["filter_$key"]) . "%'";
				}
			}
		}

		if ($having) {
			$sql .= " HAVING " . implode($having, " AND ");
		}

		$sort_data = array(
			'a.affiliate_id',
			'name',
			'a.email',
			'a.telephone',
			'a.fax',
			'a.company',
			'a.address_1',
			'a.address_2',
			'a.city',
			'country',
			'region',
			'a.code',
			'a.commission',
			'a.tax',
			'balance',
			'a.approved',
			'a.date_added',
			'a.ip',
			'a.status',
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

	public function getTotalAffiliates() {
		return $this->count;
	}

	public function quickEditAffiliate($affiliate_id, $column, $value, $lang_id=null, $data=null) {
		$editable = array('name', 'email', 'telephone', 'fax', 'company', 'address_1', 'address_2', 'city', 'postcode', 'country', 'region', 'tracking_code', 'commission', 'tax', 'approved', 'status');
		$result = false;
		if (in_array($column, $editable)) {
			if (in_array($column, array('approved', 'status')))
				$result = $this->db->query("UPDATE `" . DB_PREFIX . "affiliate` SET " . $column . " = '" . (int)$value . "' WHERE affiliate_id = '" . (int)$affiliate_id . "'");
			else if (in_array($column, array('country')))
				$result = $this->db->query("UPDATE `" . DB_PREFIX . "affiliate` SET " . $column . "_id = '" . (int)$value . "' WHERE affiliate_id = '" . (int)$affiliate_id . "'");
			else if (in_array($column, array('region')))
				$result = $this->db->query("UPDATE `" . DB_PREFIX . "affiliate` SET zone_id = '" . (int)$value . "' WHERE affiliate_id = '" . (int)$affiliate_id . "'");
			else if (in_array($column, array('commission')))
				$result = $this->db->query("UPDATE `" . DB_PREFIX . "affiliate` SET " . $column . " = '" . (float)$value . "' WHERE affiliate_id = '" . (int)$affiliate_id . "'");
			else if ($column == "name") {
				$first_name = $data['first_name'];
				$last_name = $data['last_name'];
				$result = $this->db->query("UPDATE `" . DB_PREFIX . "affiliate` SET firstname = '" . $this->db->escape($first_name) . "', lastname = '" . $this->db->escape($last_name) . "' WHERE affiliate_id = '" . (int)$affiliate_id . "'");
			} else {
				$result = $this->db->query("UPDATE `" . DB_PREFIX . "affiliate` SET " . $column . " = '" . $this->db->escape($value) . "' WHERE affiliate_id = '" . (int)$affiliate_id . "'");
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
