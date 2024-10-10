<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arComponentParameters = [
    "PARAMETERS" => [
        "SEF_MODE" => [
            "unifield_list" => [
                "NAME" => "Список элементов (универсальный для всех 3х уровней списков)",
                "DEFAULT" => "#BRAND#/#MODEL#/",
                "VARIABLES" => ["BRAND", "MODEL"],
            ],
            "notebook_detail" => [
                "NAME" => "Детальная страница ноутбука",
                "DEFAULT" => "detail/#NOTEBOOK#/",
                "VARIABLES" => ["NOTEBOOK"],
            ],
        ],
        "SEF_FOLDER" => [
            "PARENT" => "BASE",
            "NAME" => "Каталог для SEF URL",
            "TYPE" => "STRING",
            "DEFAULT" => "/catalog/",
        ],
    ],
];