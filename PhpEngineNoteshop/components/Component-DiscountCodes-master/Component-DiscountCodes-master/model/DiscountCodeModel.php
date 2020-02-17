<?php

    /**
     * Модель купона на скидку
     */
    class DiscountCodeModel extends Model
    {
        public $filter;

        public function __construct($code_id = NULL, $onlyShow = false)
        {
            global $g_databases;
            parent::__construct($g_databases->db, 'discount_codes', 'code_id', $code_id, $onlyShow);

            $this->filter = new ModelFilter($g_databases->db, $this->table, 'code_id');
        }

        public function CreateTable()
        {
            $this->db->query("CREATE TABLE IF NOT EXISTS ?#
                             (
                                `code_id` INT  NOT NULL AUTO_INCREMENT,
                                `code` VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_general_ci,

                                `can_use_count` INT DEFAULT 1, /* Сколько еще можно использовать раз */

                                `added`   INT NOT NULL,
                                `expired` INT NOT NULL,

                                `discount` FLOAT,

                                `is_removed` INT DEFAULT 0,

                                PRIMARY KEY (`code_id`)
                             ) ENGINE = MyISAM",
                             $this->table);
        }

        public function IsCodeBusy($code)
        {
            return $this->db->selectCell("SELECT COUNT(`code_id`) FROM ?# WHERE `code` LIKE ?", $this->table, $code);
        }

        public function FindCode($code)
        {
            return $this->db->selectCell("SELECT `code_id` FROM ?# WHERE `code` LIKE ?", $this->table, $code);
        }
    };
?>