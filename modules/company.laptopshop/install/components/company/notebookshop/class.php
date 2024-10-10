<?php
declare(strict_types=1);
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Iblock\Component\Tools;
use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Bitrix\Main\Page\Asset;
use Bitrix\Main\UI\Extension;
use \Bitrix\Main\Localization\Loc;

class NotebookShop extends CBitrixComponent
{
    /**
     * @return void
     * @see parent::executeComponent()
     */
    public function executeComponent()
    {
        if (!Loader::includeModule("company.laptopshop")) {
            ShowError(Loc::getMessage('LAPTOPSHOP_MODULE_NOT_LOADED'));
            return;
        }

        if ($this->arParams["SEF_MODE"] != "Y") {
            ShowError(Loc::getMessage('LAPTOPSHOP_MODULE_NOT_SEF_MODE'));
            return;
        }

        $componentPage = $this->sefMode();

        if (!$componentPage) {
            Tools::process404(
                $this->arParams["MESSAGE_404"],
                ($this->arParams["SET_STATUS_404"] === "Y"),
                ($this->arParams["SET_STATUS_404"] === "Y"),
                ($this->arParams["SHOW_404"] === "Y"),
                $this->arParams["FILE_404"]
            );
        }

        Extension::load("ui.bootstrap4");

        $this->IncludeComponentTemplate($componentPage);
    }

    /**
     * @return string имя текущей страницы компонента.
     */
    protected function sefMode()
    {
        $arComponentVariables = [];
        $arDefaultVariableAliases404 = [];
        $arDefaultUrlTemplates404 = [
            "notebook_detail" => "detail/#NOTEBOOK#/", // Детальная страница ноутбука (4й компонент)
            "notebook_list" => "#BRAND#/#MODEL#/", // Список производителей, моделей, ноутбуков (3 компонента в 1 слил)
        ];

        $this->arParams["VARIABLE_ALIASES"] ??= [];

        $arUrlTemplates = CComponentEngine::makeComponentUrlTemplates($arDefaultUrlTemplates404, $this->arParams["SEF_URL_TEMPLATES"]);
        $arVariableAliaces = CComponentEngine::makeComponentVariableAliases($arDefaultVariableAliases404, $this->arParams["VARIABLE_ALIASES"]);

        $engine = new CComponentEngine($this);
        $arVariables = [];

        $componentPage = $engine->guessComponentPath(
            $this->arParams["SEF_FOLDER"],
            $arUrlTemplates,
            $arVariables
        );

        if (!$componentPage) {
            $componentPage = "notebook_list";
        }

        if (strpos($this->arParams["SEF_FOLDER"], 'detail/') !== false) {
            $componentPage = "notebook_detail";
        }

        CComponentEngine::initComponentVariables($componentPage, $arComponentVariables, $arVariableAliaces, $arVariables);

        $this->arResult = [
            "VARIABLES" => $arVariables,
            "ALIASES" => $arUrlTemplates,
        ];
        return $componentPage;
    }

}