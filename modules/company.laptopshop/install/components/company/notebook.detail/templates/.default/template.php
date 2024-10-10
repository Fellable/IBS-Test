<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use \Bitrix\Main\Localization\Loc;
?>

<div class="container notebook-detail mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h1 class="text-light">  <?= Loc::getMessage('LAPTOPSHOP_NOTEBOOK_ABOUT'). ' ' .$arResult['NOTEBOOK']['NAME'] ?></h1>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-subtitle mb-3 text-muted"> <?= Loc::getMessage('LAPTOPSHOP_CHARACTERISTICS') ?>: </h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"> <?= Loc::getMessage('LAPTOPSHOP_MANUFACTURER_NAME') ?> : <strong><?= $arResult['NOTEBOOK']['MANUFACTURER_NAME'] ?></strong></li>
                        <li class="list-group-item"> <?= Loc::getMessage('LAPTOPSHOP_MODEL_NAME') ?> : <strong><?= $arResult['NOTEBOOK']['MODEL_NAME'] ?></strong></li>
                        <li class="list-group-item"> <?= Loc::getMessage('LAPTOPSHOP_NOTEBOOK_NAME') ?> : <strong><?= $arResult['NOTEBOOK']['NAME'] ?></strong></li>
                        <li class="list-group-item"> <?= Loc::getMessage('LAPTOPSHOP_YEAR') ?>: <strong><?= $arResult['NOTEBOOK']['YEAR'] ?></strong></li>
                        <li class="list-group-item"> <?= Loc::getMessage('LAPTOPSHOP_PRICE') ?> : <span class="badge bg-success"><?= $arResult['NOTEBOOK']['PRICE']. ' ' . Loc::getMessage('LAPTOPSHOP_VALUTE') ?> </span></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <img src="<?= $templateFolder.$arResult['NOTEBOOK']['DETAIL_IMAGE'] ?>" class="img-fluid" alt="Notebook Image">
                </div>
            </div>
        </div>
    </div>

    <!-- Раздел с опциями -->
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-secondary text-white">
            <h2 class="card-title"> <?= Loc::getMessage('OPTIONS_AVAILABLE') ?> </h2>
        </div>
        <div class="card-body">
            <?php if (!empty($arResult['OPTIONS'])): ?>
                <ul class="list-group">
                    <?php foreach ($arResult['OPTIONS'] as $option): ?>
                        <li class="list-group-item">
                            <i class="bi bi-check-circle-fill text-success me-2"></i><?= $option['OPTION_NAME'] ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-warning"><i class="bi bi-exclamation-circle-fill"></i>  <?= Loc::getMessage('OPTIONS_UNAVAILABLE') ?> </p>
            <?php endif; ?>
        </div>
    </div>
</div>
