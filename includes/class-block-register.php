<?php

if (!defined('ABSPATH'))
    exit;

class Mrifat_Extra_Block_Register
{
    public function __construct()
    {
        add_action('init', [$this, 'register_blocks']);
    }

    public function register_blocks()
    {
        register_block_type(MRIFAT_EXTRA_PATH . 'blocks/contact-form');
    }
}