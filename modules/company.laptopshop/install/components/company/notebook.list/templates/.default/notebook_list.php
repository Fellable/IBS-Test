<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use \Bitrix\Main\Localization\Loc;
?>

    <form method="GET" class="mb-4 p-2 border">
        <div class="d-flex flex-wrap align-items-start mb-2 w-100">
            <div class="d-flex flex-column me-3 flex-grow-1 text-center">
                <label for="sort_by" class="mb-2"> <?= Loc::getMessage('LAPTOPSHOP_FORM_SORTED') ?> :</label>
                <select name="sort_by" id="sort_by" class="form-control">
                    <option value="PRICE" <?= ($arResult['REQUEST']->getQuery("sort_by") == 'PRICE') ? 'selected' : '' ?>> <?= Loc::getMessage('LAPTOPSHOP_FORM_PRICE') ?>  </option>
                    <option value="YEAR" <?= ($arResult['REQUEST']->getQuery("sort_by") == 'YEAR') ? 'selected' : '' ?>> <?= Loc::getMessage('LAPTOPSHOP_FORM_YEAR') ?> </option>
                </select>
            </div>
            <div class="d-flex flex-column me-3 flex-grow-1 text-center">
                <label for="sort_order" class="mb-2"> <?= Loc::getMessage('LAPTOPSHOP_FORM_ORDER') ?>  :</label>
                <select name="sort_order" id="sort_order" class="form-control">
                    <option value="ASC" <?= ($arResult['REQUEST']->getQuery("sort_order") == 'ASC') ? 'selected' : '' ?>> <?= Loc::getMessage('LAPTOPSHOP_FORM_SORT_BY_ASC') ?> </option>
                    <option value="DESC" <?= ($arResult['REQUEST']->getQuery("sort_order") == 'DESC') ? 'selected' : '' ?>> <?= Loc::getMessage('LAPTOPSHOP_FORM_SORT_BY_DESC') ?></option>
                </select>
            </div>
            <div class="d-flex flex-column flex-grow-1 text-center">
                <label for="page_size" class="mb-2"> <?= Loc::getMessage('LAPTOPSHOP_FORM_PER_PAGE') ?> :</label>
                <select name="page_size" id="page_size" class="form-control">
                    <option value="5" <?= ($arResult['REQUEST']->getQuery("page_size") == 5) ? 'selected' : '' ?>>5</option>
                    <option value="10" <?= ($arResult['REQUEST']->getQuery("page_size") == 10) ? 'selected' : '' ?>>10</option>
                    <option value="20" <?= ($arResult['REQUEST']->getQuery("page_size") == 20) ? 'selected' : '' ?>>20</option>
                </select>
            </div>
        </div>
        <div class="d-flex flex-column align-self-stretch w-100">
            <button type="submit" class="btn btn-primary h-100 w-100"><?= Loc::getMessage('LAPTOPSHOP_FORM_APPLY') ?></button>
        </div>
    </form>


    <h3 class="w-100"> <?= Loc::getMessage('LAPTOPSHOP_NOTEBOOK_LIST') .  htmlspecialchars($arResult['MODEL']) ?>:</h3>
    <div class="row p-2">
        <?php foreach ($arResult['DATA'] as $notebook): ?>
            <div class="col-12 col-sm-6 col-lg-4 mb-4">
                <a href="<?= $arParams['SEF_FOLDER'] ?>detail/<?= $notebook['ID'] ?>/">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title">
                                    <?= $notebook['NAME'] ?>
                                </h6>
                                <h6 class="card-subtitle mb-2 text-muted">Год выпуска: <?= $notebook['YEAR'] ?></h6>
                                <p class="card-text">Цена: <?= $notebook['PRICE'] ?> руб.</p>
                            </div>
                            <div>
                                <img src="<?= $templateFolder . $notebook['LIST_IMAGE'] ?>" alt="PreviewImage"
                                     class="img-fluid notebook-image">
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

<?php
//$APPLICATION->IncludeComponent(
//    'bitrix:main.pagenavigation',
//    '',
//    array(
//        'NAV_OBJECT' => $arResult['NAV_OBJECT'],
//        'SEF_MODE' => 'N',
//        'SHOW_ALWAYS' => 'Y',
//        'TITLE' => 'Навигация по страницам',
//        'AJAX_MODE' => 'N',
//        'USE_PAGE_SIZE' => 'Y',
//    ),
//    false
//);


$requestParams = $_GET;
unset($requestParams['page']); // Причина по которой сделал ручную пагинацию
$nav = $arResult['NAV_OBJECT'];
$currentPage = $nav->getCurrentPage();
$totalPages = $nav->getPageCount();
?>

<nav aria-label="Page navigation">
  <ul class="pagination justify-content-center">

<?php
// Страница "Назад"
if ($currentPage > 1) {
    echo '<li class="page-item"><a class="page-link" href="' . $APPLICATION->GetCurPage() . '?' . http_build_query(array_merge($requestParams, ['page' => $currentPage - 1])) . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
}

// Пагинация
for ($i = 1; $i <= $totalPages; $i++): ?>
    <li class="page-item <?= ($i === $currentPage) ? 'active' : '' ?>">
        <a class="page-link" href="<?= $APPLICATION->GetCurPage() . '?' . http_build_query(array_merge($requestParams, ['page' => $i])) ?>">
            <?= $i ?>
        </a>
    </li>
<?php
endfor;

// Страница "Вперед"
if ($currentPage < $totalPages) {
    echo '<li class="page-item"><a class="page-link" href="' . $APPLICATION->GetCurPage() . '?' . http_build_query(array_merge($requestParams, ['page' => $currentPage + 1])) . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
}
?>
  </ul>
</nav>


