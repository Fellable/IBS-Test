<?php

namespace Company\Laptopshop;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\FloatField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;


class NotebookTable extends DataManager
{
    public static function getTableName()
    {
        return 'b_laptop_notebook';
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
            new IntegerField('MODEL_ID'),
            new Reference(
                'MODEL',
                ModelTable::class,
                Join::on('this.MODEL_ID', 'ref.ID')
            ),
            new IntegerField('YEAR', [
                'required' => true,
            ]),
            new FloatField('PRICE', [
                'required' => true,
            ]),
            new StringField('LIST_IMAGE', [
                'required' => false,
            ]),
            new StringField('DETAIL_IMAGE', [
                'required' => false,
            ]),
            new Reference(
                'NOTEBOOK_OPTIONS',
                NotebookOptionTable::class,
                Join::on('this.ID', 'ref.NOTEBOOK_ID')
            ),

        ];
    }
}
