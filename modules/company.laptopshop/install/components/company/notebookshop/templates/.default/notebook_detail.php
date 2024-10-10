<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$APPLICATION->IncludeComponent(
    "company:notebook.detail",
    "",
    array(
        "CACHE_TIME" => "3600",
        "CACHE_TYPE" => "A",
        "NOTEBOOK_ID" => $arResult["VARIABLES"]["NOTEBOOK"] ?? null,
        "SEF_FOLDER" => $arParams["SEF_FOLDER"]
    ),
    $component
);
