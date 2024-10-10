<?php

namespace Company\Laptopshop;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

class NotebookOptionTable extends DataManager
{
    public static function getTableName()
    {
        return 'b_laptop_notebook_option';
    }

    public static function getMap()
    {
        return [
            new IntegerField('NOTEBOOK_ID', [
                'primary' => true,
            ]),
            new IntegerField('OPTION_ID', [
                'primary' => true,
            ]),
            new Reference(
                'NOTEBOOK', // Связь с таблицей ноутбуков
                NotebookTable::class,
                Join::on('this.NOTEBOOK_ID', 'ref.ID')
            ),
            new Reference(
                'OPTION', // Связь с таблицей опций
                OptionTable::class,
                Join::on('this.OPTION_ID', 'ref.ID')
            ),
        ];
    }
}
