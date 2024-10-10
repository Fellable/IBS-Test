<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arComponentDescription = [
    "NAME" => "Списки производителей, моделей, ноутбуков",
    "DESCRIPTION" => "Обрабатывает списки производителей, моделей и ноутбуков",
    "PATH" => [
        "ID" => "company",
        "CHILD" => [
            "ID" => "laptopshop",
            "NAME" => "Управление ноутбуками"
        ],
    ],
];