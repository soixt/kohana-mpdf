<?php defined('SYSPATH') or die('No direct script access.');

// Loads mPDF and preserves the users chosen error_reporting level
$error_level = error_reporting();
require_once Kohana::find_file('vendor', 'mpdf/mpdf');
error_reporting($error_level);
