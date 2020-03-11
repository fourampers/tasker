<?php

use JasonGrimes\Paginator;

function paginate($count, $page, $perPage, $url)
{
    $totalItems = $count;
    $itemsPerPage = $perPage;
    $currentPage = $page;
    $urlPattern = $url;

    $paginator =  new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
    return $paginator;

}

function paginator($paginator)
{
    include '../app/Views/partials/pagination.php';
}

function config($field)
{
    $config = require '../app/config.php';
    return array_get($config, $field);
}

function sorting($sorting) 
{
    include '../app/Views/partials/sorting.php';
}