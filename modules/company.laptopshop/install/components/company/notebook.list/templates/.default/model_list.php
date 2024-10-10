<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use \Bitrix\Main\Localization\Loc;
?>

<div class="row p-2">
    <h3 class="w-100"> <?= Loc::getMessage('LAPTOPSHOP_MODEL_LIST') .  htmlspecialchars($arResult['BRAND']) ?>:</h3>
    <?php
    if (!empty($arResult['DATA'])): ?>
        <?php foreach ($arResult['DATA'] as $model): ?>
            <div class="col-md-4 mb-4">
                <a href="<?= $arParams['SEF_FOLDER'] . $arResult['VARIABLES']['BRAND'] . '/' . $model['ID'] . '/' ?>"
                   class="list-link">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= $model['NAME'] ?></h5>
                            <p class="card-text">  <?= Loc::getMessage('LAPTOPSHOP_VIEW_NOTEBOOK') ?> </p>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach;
    else: ?>
        <p>  <?= Loc::getMessage('LAPTOPSHOP_MODELS_NOT_FOUND') ?> </p>
    <?php
    endif; ?>
</div>
