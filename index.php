<?php

require_once('ConsoleApp.php');
require_once('Product.php');

$args = $argv;

if (!in_array($args[2], ['calculate', 'add_product', 'edit_product', 'delete_product'])) {
    echo "Invalid action\n";
    exit();
}

if ($args[2] === 'calculate') {
    ConsoleApp::command($args[1], 'calculate');
    exit();
}

if ($args[2] === 'add_product') {
    ConsoleApp::command($args[1], 'add_product', $args[3], $args[4]);
    exit();
}

if ($args[2] === 'edit_product') {
    ConsoleApp::command($args[1], 'edit_product', $args[3], $args[4], $args[5]);
    exit();
}

if ($args[2] === 'delete_product') {
    ConsoleApp::command($args[1], 'delete_product', $args[3]);
    exit();
}
