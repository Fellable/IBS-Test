<?php
declare(strict_types=1);
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();


use Bitrix\Main\ModuleManager;
use Bitrix\Main\Application;
use Bitrix\Main\Entity\Base;
use Bitrix\Main\Loader;
use \Bitrix\Main\Localization\Loc;
use Company\Laptopshop\ManufacturerTable;
use Company\Laptopshop\ModelTable;
use Company\Laptopshop\NotebookOptionTable;
use Company\Laptopshop\NotebookTable;
use Company\Laptopshop\OptionTable;
use Company\Laptopshop\Seeder;
use Bitrix\Main\Type\ParameterDictionary;
use Bitrix\Main\Context;


class company_laptopshop extends CModule
{
    var $MODULE_ID;
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;
    var $MODULE_GROUP_RIGHTS = "Y";

    public function __construct()
    {
        $arModuleVersion = array();
        require_once(__DIR__ . "/version.php");

        $this->MODULE_ID = "company.laptopshop";
        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        $this->MODULE_NAME = Loc::getMessage("SHOP_LAPTOPS_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("SHOP_LAPTOPS_MODULE_DESC");

        $this->PARTNER_NAME = Loc::getMessage("SHOP_LAPTOPS_PARTNER_NAME");
        $this->PARTNER_URI = Loc::getMessage("SHOP_LAPTOPS_PARTNER_URI");

        $this->MODULE_SORT = 1;
        $this->SHOW_SUPER_ADMIN_GROUP_RIGHTS = 'Y';
        $this->MODULE_GROUP_RIGHTS = "Y";
    }

    public function GetPath($notDocumentRoot = false)
    {
        if ($notDocumentRoot)
            return str_ireplace(Application::getDocumentRoot(), '', dirname(__DIR__));
        else
            return dirname(__DIR__);
    }

    public function isVersionD7()
    {
        return CheckVersion(\Bitrix\Main\ModuleManager::getVersion('main'), '14.00.00');
    }


    public function InstallDB()
    {
        Loader::includeModule($this->MODULE_ID);

        $connection = Application::getConnection();

        $tables = [
            ManufacturerTable::class,
            ModelTable::class,
            NotebookTable::class,
            OptionTable::class,
            NotebookOptionTable::class
        ];

        foreach ($tables as $table) {
            !$connection->isTableExists($table::getTableName()) ? $table::getEntity()->createDbTable() : null;
        }

        return true;
    }


    public function UnInstallDB()
    {
            Loader::includeModule($this->MODULE_ID);

            Application::getConnection(NotebookOptionTable::getConnectionName())->
            queryExecute('drop table if exists ' . Base::getInstance('\Company\Laptopshop\NotebookOptionTable')->getDBTableName());

            Application::getConnection(OptionTable::getConnectionName())->
            queryExecute('drop table if exists ' . Base::getInstance('\Company\Laptopshop\OptionTable')->getDBTableName());


            Application::getConnection(NotebookTable::getConnectionName())->
            queryExecute('drop table if exists ' . Base::getInstance('\Company\Laptopshop\NotebookTable')->getDBTableName());

            Application::getConnection(ModelTable::getConnectionName())->
            queryExecute('drop table if exists ' . Base::getInstance('\Company\Laptopshop\ModelTable')->getDBTableName());

            Application::getConnection(ManufacturerTable::getConnectionName())->
            queryExecute('drop table if exists ' . Base::getInstance('\Company\Laptopshop\ManufacturerTable')->getDBTableName());

            return true;
    }


    function InstallEvents()
    {
        return true;
    }

    function UnInstallEvents()
    {
        return true;
    }

    function InstallFiles($arParams = array())
    {
        try {
            $path = $this->GetPath() . "/install/components";
            if (\Bitrix\Main\IO\Directory::isDirectoryExists($path)) {
                $destination = $_SERVER["DOCUMENT_ROOT"] . "/local/components";
                if (!CopyDirFiles($path, $destination, true, true)) {
                    // Нужно проверить права на local - в б24 не копируется без этого
                    // sudo chown -R www-data:www-data /home/bitrix/www/local/
                    // sudo chmod -R 775 /home/bitrix/www/local/
                    AddMessage2Log("Ошибка копирования из $path в $destination", $this->MODULE_ID);
                }
            } else {
                throw new \Bitrix\Main\IO\InvalidPathException($path);
            }
        } catch (\Exception $e) {
            AddMessage2Log("Ошибка: " . $e->getMessage(), $this->MODULE_ID);
        }
        return true;
    }

    public function UnInstallFiles()
    {
        DeleteDirFilesEx("/local/components/company/");
        return true;
    }

    public function DoInstall()
    {
        global $APPLICATION;

        if ($this->isVersionD7()) {
            $request = Context::getCurrent()->getRequest();


            if ($request['step'] < 2) {
                $APPLICATION->IncludeAdminFile("Установка модуля Магазин ноутбуков", __DIR__ . "/step1.php");
            } else {
                ModuleManager::registerModule($this->MODULE_ID);

                $request['drop_tables'] === "Y" ? $this->UnInstallDB() : null;

                Loader::includeModule($this->MODULE_ID);

                $this->InstallDB();

                $request['drop_tables'] === "Y" ? Seeder::invoke() : null;

                $this->InstallFiles();

                $APPLICATION->IncludeAdminFile("Установка завершена", __DIR__ . "/step2.php");
            }
        } else {
            $APPLICATION->ThrowException(Loc::getMessage("SHOP_LAPTOPS_INSTALL_ERROR_VERSION"));
        }
    }

    public function DoUninstall()
    {
        global $APPLICATION;

        $request = Context::getCurrent()->getRequest();

        if ($request['step'] < 2) {
            $APPLICATION->IncludeAdminFile(Loc::getMessage("SHOP_LAPTOPS_UNINSTALL_TITLE"), $this->GetPath() . "/install/unstep1.php");
        } elseif ($request["step"] == 2) {
            $request['savedata'] === "Y" ? $this->UnInstallDB() : null;
            ModuleManager::unRegisterModule($this->MODULE_ID);
            $APPLICATION->IncludeAdminFile(Loc::getMessage("SHOP_LAPTOPS_UNINSTALL_TITLE"), $this->GetPath() . "/install/unstep2.php");
        }
    }
}