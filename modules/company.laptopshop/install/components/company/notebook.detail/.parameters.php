<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arComponentParameters = array(
    "GROUPS" => array(
        "VISUAL" => array(
            "NAME" => "Настройки отображения",
        ),
    ),
    "PARAMETERS" => array(
        "SHOW_OPTIONS" => array(
            "PARENT" => "VISUAL",
            "NAME" => "Показывать опции ноутбука",
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
        ),
        "CACHE_TYPE" => array(
            "PARENT" => "CACHE_SETTINGS",
            "NAME" => "Тип кэширования",
            "TYPE" => "LIST",
            "VALUES" => array(
                "A" => "Авто",
                "Y" => "Включить",
                "N" => "Выключить",
            ),
            "DEFAULT" => "A",
        ),
        "CACHE_TIME" => array(
            "DEFAULT" => 3600,
        ),
    ),
);