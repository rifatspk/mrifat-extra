<?php

if (!defined('ABSPATH'))
    exit;

class Mrifat_Extra_Database
{
    private $table_name;

    public function __construct()
    {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'mrifat_contacts';

        add_action('init', [$this, 'create_table']);
    }

    public function create_table()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS {$this->table_name} (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            email varchar(255) NOT NULL,
            business_name varchar(255) DEFAULT NULL,
            service varchar(255) DEFAULT NULL,
            subject varchar(255) NOT NULL,
            timeline varchar(100) DEFAULT NULL,
            message text NOT NULL,
            website_audit varchar(10) DEFAULT 'yes',
            privacy_policy varchar(10) DEFAULT 'yes',
            ip_address varchar(100) DEFAULT NULL,
            user_agent text DEFAULT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            status varchar(20) DEFAULT 'unread',
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    public function insert_contact($data)
    {
        global $wpdb;

        $result = $wpdb->insert(
            $this->table_name,
            $data,
            [
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s'
            ]
        );

        return $result !== false ? $wpdb->insert_id : false;
    }

    public function delete_contact($id)
    {
        global $wpdb;
        return $wpdb->delete($this->table_name, ['id' => $id], ['%d']);
    }

    public function update_status($id, $status)
    {
        global $wpdb;
        return $wpdb->update(
            $this->table_name,
            ['status' => $status],
            ['id' => $id],
            ['%s'],
            ['%d']
        );
    }

    public function get_contacts($limit = 20, $offset = 0, $filter = 'all', $search = '')
    {
        global $wpdb;

        $where_clauses = [];
        $prepare_values = [];

        // Filter by status
        if ($filter !== 'all') {
            $where_clauses[] = "status = %s";
            $prepare_values[] = $filter;
        }

        // Search functionality
        if (!empty($search)) {
            $where_clauses[] = "(name LIKE %s OR email LIKE %s OR subject LIKE %s OR message LIKE %s)";
            $search_term = '%' . $wpdb->esc_like($search) . '%';
            $prepare_values[] = $search_term;
            $prepare_values[] = $search_term;
            $prepare_values[] = $search_term;
            $prepare_values[] = $search_term;
        }

        $where_sql = '';
        if (!empty($where_clauses)) {
            $where_sql = 'WHERE ' . implode(' AND ', $where_clauses);
        }

        // Add limit and offset values
        $prepare_values[] = $limit;
        $prepare_values[] = $offset;

        $query = "SELECT * FROM {$this->table_name} {$where_sql} ORDER BY created_at DESC LIMIT %d OFFSET %d";

        if (!empty($prepare_values)) {
            return $wpdb->get_results($wpdb->prepare($query, $prepare_values));
        } else {
            return $wpdb->get_results($query);
        }
    }

    public function get_contact_count($filter = 'all', $search = '')
    {
        global $wpdb;

        $where_clauses = [];
        $prepare_values = [];

        // Filter by status
        if ($filter !== 'all') {
            $where_clauses[] = "status = %s";
            $prepare_values[] = $filter;
        }

        // Search functionality
        if (!empty($search)) {
            $where_clauses[] = "(name LIKE %s OR email LIKE %s OR subject LIKE %s OR message LIKE %s)";
            $search_term = '%' . $wpdb->esc_like($search) . '%';
            $prepare_values[] = $search_term;
            $prepare_values[] = $search_term;
            $prepare_values[] = $search_term;
            $prepare_values[] = $search_term;
        }

        $where_sql = '';
        if (!empty($where_clauses)) {
            $where_sql = 'WHERE ' . implode(' AND ', $where_clauses);
        }

        $query = "SELECT COUNT(*) FROM {$this->table_name} {$where_sql}";

        if (!empty($prepare_values)) {
            return $wpdb->get_var($wpdb->prepare($query, $prepare_values));
        } else {
            return $wpdb->get_var($query);
        }
    }

    public function get_contact_stats()
    {
        global $wpdb;

        $stats = [
            'total' => 0,
            'unread' => 0,
            'read' => 0,
            'replied' => 0
        ];

        $results = $wpdb->get_results(
            "SELECT status, COUNT(*) as count FROM {$this->table_name} GROUP BY status"
        );

        foreach ($results as $result) {
            $stats[$result->status] = $result->count;
            $stats['total'] += $result->count;
        }

        return $stats;
    }

    public function get_contact_by_id($id)
    {
        global $wpdb;

        return $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$this->table_name} WHERE id = %d",
                $id
            )
        );
    }
}