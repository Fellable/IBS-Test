<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

$arComponentParameters = array(
    "GROUPS" => array(
        "SORT_SETTINGS" => array(
            "NAME" => "Настройки сортировки",
        ),
        "PAGINATION_SETTINGS" => array(
            "NAME" => "Настройки постраничной навигации",
        ),
    ),
    "PARAMETERS" => array(
        "DEFAULT_SORT_BY" => array(
            "PARENT" => "SORT_SETTINGS",
            "NAME" => "Поле сортировки по умолчанию",
            "TYPE" => "LIST",
            "VALUES" => array(
                "PRICE" => "Цена",
                "YEAR" => "Год выпуска",
            ),
            "DEFAULT" => "PRICE",
            "ADDITIONAL_VALUES" => "N",
        ),
        "DEFAULT_SORT_ORDER" => array(
            "PARENT" => "SORT_SETTINGS",
            "NAME" => "Порядок сортировки по умолчанию",
            "TYPE" => "LIST",
            "VALUES" => array(
                "ASC" => "По возрастанию",
                "DESC" => "По убыванию",
            ),
            "DEFAULT" => "ASC",
            "ADDITIONAL_VALUES" => "N",
        ),
        "DEFAULT_PAGE_SIZE" => array(
            "PARENT" => "PAGINATION_SETTINGS",
            "NAME" => "Количество элементов на странице по умолчанию",
            "TYPE" => "STRING",
            "DEFAULT" => "10",
        ),
        "SEF_FOLDER" => array(
            "PARENT" => "BASE",
            "NAME" => "Папка ЧПУ (SEF)",
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "SEF_URL_TEMPLATES" => array(
            "PARENT" => "BASE",
            "NAME" => "Шаблоны URL для ЧПУ (SEF)",
            "TYPE" => "STRING",
            "MULTIPLE" => "Y",
            "DEFAULT" => array(),
        ),
        "CACHE_TIME"  =>  array("DEFAULT" => 36000000),
    ),
);