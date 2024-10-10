<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

// Определяем текущие параметры сортировки и размера страницы из $_GET (только для ноутбуков)
$sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'PRICE';
$sortOrder = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';
$pageSize = isset($_GET['page_size']) ? (int)$_GET['page_size'] : 10;
?>




<div class="row p-2">
    <?php if ($arResult["COMPONENT_PAGE"] === "manufacturer_list"): ?>



    <?php elseif ($arResult["COMPONENT_PAGE"] === "model_list"): ?>


    <?php elseif ($arResult["COMPONENT_PAGE"] === "notebook_list"): ?>

    <?php endif; ?>
</div>

<!-- Показать постраничную навигацию, только если есть список ноутбуков -->
<?php if ($arResult["COMPONENT_PAGE"] === "notebook_list" && !empty($arResult['NOTEBOOKS'])): ?>
    <?php  ?>
<?php elseif ($arResult["COMPONENT_PAGE"] === "manufacturer_list" && empty($arResult['MANUFACTURERS'])): ?>
    <p>Производители не найдены.</p>
<?php elseif ($arResult["COMPONENT_PAGE"] === "model_list" && empty($arResult['MODELS'])): ?>
    <p>Модели не найдены.</p>
<?php elseif ($arResult["COMPONENT_PAGE"] === "notebook_list" && empty($arResult['NOTEBOOKS'])): ?>
    <p>Ноутбуки не найдены.</p>
<?php endif; ?>
