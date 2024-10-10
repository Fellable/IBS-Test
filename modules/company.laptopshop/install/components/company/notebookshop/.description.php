<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$arComponentDescription = array(
    'NAME' => 'Интернет-магазин ноутбуков',
    'DESCRIPTION' => 'Компонент для информационного блока',
    'CACHE_PATH' => 'Y',
    'SORT' => 40,
    'COMPLEX' => 'Y',
    'PATH' => array(
        'ID' => 'company',
        'NAME' => 'Тестовое задание',
        'CHILD' => array(
            'ID' => 'laptopshop',
            'NAME' => 'Магазин ноутбуков'
        )
    )
);