<?php

namespace Company\Laptopshop;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

class OptionTable extends DataManager
{
    public static function getTableName()
    {
        return 'b_laptop_option';
    }

    public static function getMap()
    {
        return [
            new IntegerField('ID', [
                'primary' => true,
                'autocomplete' => true,
            ]),
            new StringField('NAME', [
                'required' => true,
            ]),
            new Reference(
                'NOTEBOOK_OPTIONS',
                NotebookOptionTable::class,
                Join::on('this.ID', 'ref.OPTION_ID')
            ),
        ];
    }
}
