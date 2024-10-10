<?php

namespace Company\Laptopshop;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Company\Laptopshop\ManufacturerTable;
use Company\Laptopshop\ModelTable;
use Company\Laptopshop\NotebookTable;
use Company\Laptopshop\OptionTable;
use Company\Laptopshop\NotebookOptionTable;
use Bitrix\Main\SystemException;
use Exception;

class Seeder extends DataManager
{
    public static function invoke()
    {
        global $APPLICATION;

        try {
            Loader::includeModule('company.laptopshop');
            self::seedManufacturers();
            self::seedModels();
            self::seedNotebooks(55);
            self::seedOptions();
            self::seedNotebookOptions();
        } catch (Exception $e) {
            $APPLICATION->ThrowException('Ошибка при выполнении сидера: ' . $e->getMessage());
        }
    }

    private static function seedManufacturers()
    {
        global $APPLICATION;
        $manufacturers = [
            ['NAME' => 'Dell'],
            ['NAME' => 'Asus'],
            ['NAME' => 'Apple']
        ];

        foreach ($manufacturers as $manufacturer) {
            try {
                ManufacturerTable::add($manufacturer);
            } catch (SystemException $e) {
                $APPLICATION->ThrowException("Ошибка добавления производителя: {$manufacturer['NAME']}. Ошибка: " . $e->getMessage());
            }
        }
    }

    private static function seedModels()
    {
        global $APPLICATION;
        $models = [
            ['NAME' => 'Vostro', 'MANUFACTURER_ID' => 1],
            ['NAME' => 'Zenbook', 'MANUFACTURER_ID' => 2],
            ['NAME' => 'MacBook Pro', 'MANUFACTURER_ID' => 3],
            ['NAME' => 'MacBook Air', 'MANUFACTURER_ID' => 3]
        ];

        foreach ($models as $modelData) {
            try {
                ModelTable::add($modelData);
            } catch (SystemException $e) {
                $APPLICATION->ThrowException("Ошибка добавления модели: {$modelData['NAME']}. Ошибка: " . $e->getMessage());
            }
        }
    }

    private static function seedNotebooks(int $count = 10)
    {
        global $APPLICATION;

        $models = ModelTable::getList([
            'select' => ['ID', 'NAME'],
        ])->fetchAll();

        if (empty($models)) {
            $APPLICATION->ThrowException('Ошибка получения моделей: Модели не найдены.');
            return;
        }

        $years = range(2016, date('Y'));
        $baseNames = ['Alienware', 'xPredator', 'Radiotehnika', 'Aorus', 'Aorus Master', 'Xperia', 'Sony Ericsson', 'Nikon', 'Baikal'];

        for ($i = 1; $i <= $count; $i++) {
            $num = rand(1, 4);
            $notebook = [
                'NAME' => $baseNames[array_rand($baseNames)] . " " . rand(1, 100),
                'YEAR' => $years[array_rand($years)],
                'PRICE' => rand(30000, 150000),
                'LIST_IMAGE' => '/images/notebooks/notebook_' . $num . '_256x256.jpg',
                'DETAIL_IMAGE' => '/images/notebook_' . $num . '_512x512.jpg',
                'MODEL_ID' => $models[array_rand($models)]['ID'],
            ];

            try {
                NotebookTable::add($notebook);
            } catch (SystemException $e) {
                $APPLICATION->ThrowException("Ошибка добавления ноутбука: {$notebook['NAME']}. Ошибка: " . $e->getMessage());
            }
        }
    }

    private static function seedOptions()
    {
        global $APPLICATION;
        $options = [
            ['NAME' => 'Wi-Fi 6.0 / 7.0 '],
            ['NAME' => 'Экран на выбор: FullHD 120 HZ или 4K 60HZ'],
            ['NAME' => 'Установка до 128гб ОЗУ'],
            ['NAME' => 'Матрица: VA или IPS'],
        ];

        foreach ($options as $option) {
            try {
                OptionTable::add($option);
            } catch (SystemException $e) {
                $APPLICATION->ThrowException("Ошибка добавления опции: {$option['NAME']}. Ошибка: " . $e->getMessage());
            }
        }
    }

    private static function seedNotebookOptions()
    {
        global $APPLICATION;

        $notebooks = NotebookTable::getList([
            'select' => ['ID', 'NAME'],
        ])->fetchAll();

        $options = OptionTable::getList([
            'select' => ['ID', 'NAME'],
        ])->fetchAll();

        foreach ($notebooks as $notebook) {
            $randomOptions = array_rand($options, rand(1, count($options)));

            $randomOptions = is_array($randomOptions) ? $randomOptions : [$randomOptions];

            foreach ($randomOptions as $optionIndex) {
                $optionID = $options[$optionIndex]['ID'];
                try {
                    NotebookOptionTable::add([
                        'NOTEBOOK_ID' => $notebook['ID'],
                        'OPTION_ID' => $optionID,
                    ]);
                } catch (SystemException $e) {
                    $APPLICATION->ThrowException("Ошибка добавления опции для ноутбука: {$notebook['NAME']} (ID: {$notebook['ID']}). Ошибка: " . $e->getMessage());
                }
            }
        }
    }
}
