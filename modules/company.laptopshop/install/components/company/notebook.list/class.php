<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Context;
use Company\Laptopshop\ManufacturerTable;
use Company\Laptopshop\ModelTable;
use Company\Laptopshop\NotebookTable;
use Bitrix\Main\UI\PageNavigation;
use Bitrix\Main\Page\Asset;

/**
 *  Компонент для отображения списка ноутбуков, моделей и производителей.
 *  Обработка данных / фильтрация / сортировка / пагинация для notebook_list.
 *  Я бы сделал в 3 компонента списки, а не в 1, т.к. мне кажется перегруженным.
 */
class NotebookListComponent extends CBitrixComponent
{

    /**
     * @see parent::executeComponent()
     * @return void
     */
    public function executeComponent()
    {
        if (!Loader::includeModule("company.laptopshop")) {
            ShowError("Модуль company.laptopshop не загружен");
            return;
        }

        $this->arResult = [];
        $this->determineLevel();

        $componentPage = '';

        $comp = $this->arResult["COMPONENT_PAGE"];
        $usePagination = false;  // Пагинация off


        if ($comp == 'manufacturer_list') {
            $componentPage = 'manufacturer_list';
            $className = ManufacturerTable::class;
            $parameters = [
                'select' => ['ID', 'NAME'],
                'order' => ['NAME' => 'ASC']
            ];
        }

        if ($comp == 'model_list') {
            $componentPage = 'model_list';
            $className = ModelTable::class;
            $parameters = [
                'select' => ['ID', 'NAME'],
                'filter' => ['MANUFACTURER.ID' => $this->arResult["VARIABLES"]["BRAND"]],
                'order' => ['NAME' => 'ASC']
            ];
        }

        if ($comp == 'notebook_list') {
            $componentPage = 'notebook_list';
            $className = NotebookTable::class;
            $parameters = [
                'select' => ['ID', 'NAME', 'YEAR', 'PRICE', 'LIST_IMAGE', 'DETAIL_IMAGE'],
                'filter' => ['MODEL.ID' => $this->arResult["VARIABLES"]["MODEL"]],
            ];
            $usePagination = true;
        }

        if ($usePagination) {
            $nav = $this->getPagination();
            $parameters['limit'] = $nav->getLimit();
            $parameters['offset'] = $nav->getOffset();

            // Добавляем сортировку
            $request = Context::getCurrent()->getRequest();
            $sortBy = in_array($request->getQuery("sort_by"), ['PRICE', 'YEAR']) ?
                $request->getQuery("sort_by") : 'PRICE'; // Установим сортировку по цене по умолчанию
            $sortOrder = in_array($request->getQuery("sort_order"), ['ASC', 'DESC']) ?
                $request->getQuery("sort_order") : 'ASC'; // По умолчанию по возрастанию

            $parameters['order'] = [$sortBy => $sortOrder]; // Обновляем параметры сортировки
            $this->arResult['REQUEST'] = Context::getCurrent()->getRequest();
        }

        if (mb_strlen($componentPage) == 0) {
            $componentPage = 'undefined';
        }

        if ($componentPage != 'undefined') {
            $items = $className::getList($parameters);
            if ($usePagination) {
                $totalCount = $className::getCount($parameters['filter']); // Подсчет общего количества записей для текущего фильтра
                $nav->setRecordCount($totalCount); // Устанавливаем количество записей
                $this->arResult['NAV_OBJECT'] = $nav;  // Добавляем объект навигации в arResult
            }

            foreach ($items as $item) {
                $this->arResult['DATA'][] = $item;
            }
        }
        $this->includeComponentTemplate($componentPage);
    }



    /**
     * Определяет текущий уровень URL и тип компонента (производители, модели или ноутбуки).
     * На основе переданных параметров SEF_URL_TEMPLATES определяет, какой раздел каталога будет отображен.
     * @return void
     */
    protected function determineLevel()
    {
        $arVariables = [];
        $arDefaultUrlTemplates404 = [
            "manufacturer_list" => "",
            "model_list" => "#BRAND#/",
            "notebook_list" => "#BRAND#/#MODEL#/",
        ];

        $arUrlTemplates = CComponentEngine::makeComponentUrlTemplates(
            $arDefaultUrlTemplates404,
            $this->arParams["SEF_URL_TEMPLATES"]
        );

        $engine = new CComponentEngine($this);
        $componentPage = $engine->guessComponentPath(
            $this->arParams["SEF_FOLDER"],
            $arUrlTemplates,
            $arVariables
        );

        if (!$componentPage) {
            $componentPage = "manufacturer_list";
        }

        CComponentEngine::initComponentVariables($componentPage, [], [], $arVariables);

        $this->arResult["VARIABLES"] = $arVariables;
        $this->arResult["COMPONENT_PAGE"] = $componentPage;
    }


    /**
     * Пагинация основана на текущем запросе и заданных параметрах (количество элементов на странице и текущая страница).
     * @return PageNavigation Объект пагинации
     */
    protected function getPagination()
    {
        $request = Context::getCurrent()->getRequest();
        $pageSize = max((int)$request->getQuery("page_size"), 5); // Минимум 10 элементов на странице
        $pageNumber = max((int)$request->getQuery("page"), 1); // Минимум первая страница

        $nav = new PageNavigation("page");
        $nav->allowAllRecords(false)
            ->setPageSize($pageSize)
            ->setCurrentPage($pageNumber);

        return $nav;
    }
}