<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Company\Laptopshop\NotebookTable;
use Company\Laptopshop\OptionTable;
use Company\Laptopshop\NotebookOptionTable;
use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use \Bitrix\Main\Localization\Loc;

class NotebookDetailComponent extends CBitrixComponent
{
    /**
     * @return void
     * @throws \Bitrix\Main\ArgumentNullException если неверно передан параметр 'NOTEBOOK_ID'
     * @see parent::executeComponent()
     */
    public function executeComponent()
    {
        if (!Loader::includeModule("company.laptopshop")) {
            ShowError('Module company.laptopshop not loaded');
            return;
        }

        $notebookId = (int)$this->arParams['NOTEBOOK_ID'];

        $noteBook = NotebookTable::query()
            ->setSelect(['*', 'MODEL', 'MODEL.MANUFACTURER']) // Запрашиваем опции через связную таблицу
            ->where('ID', $notebookId)
            ->fetchObject();

        if ($noteBook) {
            $this->arResult['NOTEBOOK'] = [
                'NAME' => $noteBook->getName(),
                'MODEL_NAME' => $noteBook->getModel() ? $noteBook->getModel()->getName() : '',
                'MANUFACTURER_NAME' => $noteBook->getModel() && $noteBook->getModel()->getManufacturer()
                    ? $noteBook->getModel()->getManufacturer()->getName()
                    : '',
                'PRICE' => $noteBook->getPrice() ?? '',
                'YEAR' => $noteBook->getYear() ?? '',
                'DETAIL_IMAGE' => $noteBook->getDetailImage(),
            ];

            // Получение и добавление опций ноутбука
            $this->arResult['OPTIONS'] = $this->getNotebookOptions($notebookId);
        } else {
            throw new \Bitrix\Main\ArgumentNullException('NOTEBOOK_ID');
        }
        // Подключение шаблона
        $this->includeComponentTemplate();
    }


    /**
     * Метод для получения привязанных опций ноутбука
     *
     * @param int $notebookId
     * @return array
     *
     */
    private function getNotebookOptions(int $notebookId): array
    {
        $options = NotebookOptionTable::getList([
            'select' => ['OPTION_ID', 'OPTION_NAME' => 'OPTION.NAME'],
            'filter' => ['NOTEBOOK_ID' => $notebookId],
            'runtime' => [
                new \Bitrix\Main\Entity\ReferenceField(
                    'OPTION',
                    OptionTable::getEntity(),
                    ['=this.OPTION_ID' => 'ref.ID'],
                    ['join_type' => 'LEFT']
                )
            ]
        ]);
        return $options->fetchAll();
    }
}
