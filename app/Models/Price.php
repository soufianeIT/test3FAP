<?php

function getFormattedPrice($priceInDecimals)
{
    $price = floatval($priceInDecimals) / 100;

    return number_format($price, 2, ',', ' ') . ' €';
}