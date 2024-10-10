<?php

namespace Company\Laptopshop;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;


class ModelTable extends DataManager
{
    public static function getTableName()
    {
        return 'b_laptop_model';
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
            new IntegerField('MANUFACTURER_ID'),
            new Reference(
                'MANUFACTURER',
                ManufacturerTable::class,
                Join::on('this.MANUFACTURER_ID', 'ref.ID')
            ),
        ];
    }
}
