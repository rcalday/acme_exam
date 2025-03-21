<?php
// File: controller.php
require_once 'Basket.php';

$catalogue = [
    'R01' => 32.95,
    'G01' => 24.95,
    'B01' => 7.95,
];

$deliveryRules = [
    50 => 4.95,
    90 => 2.95,
    PHP_INT_MAX => 0,
];

$offers = [
    'R01' => 'buy one get second half price',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productsInput = $_POST['products'] ?? '';
    $productCodes = array_map('trim', explode(',', strtoupper($productsInput)));

    try {
        $basket = new App\Basket($catalogue, $deliveryRules, $offers);
        foreach ($productCodes as $code) {
            $basket->add($code);
        }
        $total = $basket->total();
        header('Location: index.php?total=' . urlencode($total));
        exit;
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
