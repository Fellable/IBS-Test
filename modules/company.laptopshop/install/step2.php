<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

if (!check_bitrix_sessid())
    return;

if ($ex = $APPLICATION->GetException())
    echo CAdminMessage::ShowMessage(array(
        "TYPE" => "ERROR",
        "MESSAGE" => "Возникла ошибка в процессе установки",
        "DETAILS" => $ex->GetString(),
        "HTML" => true,
    ));
else
    echo CAdminMessage::ShowNote(Loc::getMessage("SHOP_LAPTOPS_INSTALL_OK"));
?>

<form action="<?= $APPLICATION->GetCurPage(); ?>">
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
    <input type="submit" name="" value="<?= Loc::getMessage("MOD_BACK"); ?>">
<form>