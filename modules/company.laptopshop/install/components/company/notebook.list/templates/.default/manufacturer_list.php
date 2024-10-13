<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use \Bitrix\Main\Localization\Loc;
?>

<div class="row p-2">
    <h3 class="w-100"><?= Loc::getMessage('LAPTOPSHOP_MANUFACTURER_LIST')?> :</h3>
    <?php
    if (!empty($arResult['DATA'])): ?>
        <?php foreach ($arResult['DATA'] as $manufacturer): ?>
            <div class="col-md-4 mb-4">
                <a href="<?= $arParams['SEF_FOLDER'] . $manufacturer['ID'] . '/' ?>" class="list-link text-primary text-decoration-none">
                    <div class="card hover-effect">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= $manufacturer['NAME'] ?></h5>
                            <p class="card-text"> <?= Loc::getMessage('LAPTOPSHOP_VIEW_MODEL')?> </p>
                        </div>
                    </div>
                </a>
            </div>
        <?php
        endforeach;
    else: ?>
        <p>  <?= Loc::getMessage('LAPTOPSHOP_MANUFACTURER_NOT_FOUND')?> </p>
    <?php
    endif; ?>
</div>
