<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Shell
 * @copyright   Copyright (c) 2009 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

$MAGE_BASE_DIR = rtrim(realpath(__DIR__ . '/../../../../../htdocs/'), '/') . '/';
if (!file_exists(MAGE_BASE_DIR)) {
    $MAGE_BASE_DIR = rtrim(realpath(__DIR__ . '/../../../../../'), '/') . '/';
}

require_once $MAGE_BASE_DIR . '/shell/abstract.php';

/**
 * Magento Compiler Shell Script
 *
 * @category    Mage
 * @package     Mage_Shell
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Shell_Compiler extends Mage_Shell_Abstract
{
    private function removeMediaVersioning() {
        $versioning_path = rtrim(Mage::getBaseDir('media'), '/') . '/' . Hevelop_StaticVersioning_Model_Store::VERSIONING_FILE;
        unlink($versioning_path);

        return $versioning_path;
    }

    private function removeJsVersioning() {
        $versioning_path = rtrim(Mage::getBaseDir(), '/') . '/js/' . Hevelop_StaticVersioning_Model_Store::VERSIONING_FILE;
        unlink($versioning_path);

        return $versioning_path;
    }

    private function removeSkinVersioning() {
        $versioning_path = rtrim(Mage::getBaseDir('skin'), '/') . '/' . Hevelop_StaticVersioning_Model_Store::VERSIONING_FILE;
        unlink($versioning_path);

        return $versioning_path;
    }

    private function removeAllVersioning() {
        return [
            $this->removeMediaVersioning(),
            $this->removeJsVersioning(),
            $this->removeSkinVersioning()
        ];
    }

    private function generateVersioningFile($versioning_path) {
        if (!file_exists($versioning_path)) {
            $v = time();
            file_put_contents($versioning_path, (string) $v);
        }
        return $versioning_path;
    }

    private function regenerateMediaVersioning() {
        $versioning_path = $this->removeMediaVersioning();
        $versioning_path = $this->generateVersioningFile($versioning_path);
        return $versioning_path;
    }

    private function regenerateJsVersioning() {
        $versioning_path = $this->removeJsVersioning();
        $versioning_path = $this->generateVersioningFile($versioning_path);
        return $versioning_path;
    }

    private function regenerateSkinVersioning() {
        $versioning_path = $this->removeSkinVersioning();
        $versioning_path = $this->generateVersioningFile($versioning_path);
        return $versioning_path;
    }

    private function regenerateAllVersioning() {
        return [
            $this->regenerateMediaVersioning(),
            $this->regenerateJsVersioning(),
            $this->regenerateSkinVersioning()
        ];
    }

    /**
     * Run script
     *
     */
    public function run()
    {
        if ($this->getArg('skin')) {
            Hevelop_StaticVersioning_Model_Store::PATH_PREFIX;
            $file_path = $this->removeSkinVersioning();
            echo "Removed skin versioning file ($file_path)\n";
        } else if ($this->getArg('js')) {
            $file_path = $this->removeJsVersioning();
            echo "Removed js versioning file ($file_path)\n";
        } else if ($this->getArg('media')) {
            $file_path = $this->removeMediaVersioning();
            echo "Removed media versioning file ($file_path)\n";
        } else if ($this->getArg('all')) {
            $file_paths = $this->removeAllVersioning();
            echo "Removed all versioning files (" . join(", ", $file_paths) . ")\n";
        } else if ($this->getArg('regenerate-skin')) {
            $file_path = $this->regenerateSkinVersioning();
            echo "Regenerated js versioning file ($file_path)\n";
        } else if ($this->getArg('regenerate-js')) {
            $file_path = $this->regenerateJsVersioning();
            echo "Regenerated js versioning file ($file_path)\n";
        } else if ($this->getArg('regenerate-media')) {
            $file_path = $this->regenerateMediaVersioning();
            echo "Regenerated media versioning file ($file_path)\n";
        } else if ($this->getArg('regenerate-all')) {
            $file_paths = $this->regenerateAllVersioning();
            echo "Regenerated all versioning files (" . join(", ", $file_paths) . ")\n";
        } else {
            echo $this->usageHelp();
        }
    }

    /**
     * Retrieve Usage Help Message
     *
     */
    public function usageHelp()
    {
        return <<<USAGE
Usage:  php -f hevelop_staticversioning_clearversion.php -- [options]
  skin      Delete skin version file      
  js        Delete js version file
  media     Delete media version file
  all       Delete skin, js and media version file
  regenerate-skin      Regenerate skin version file      
  regenerate-js        Regenerate js version file
  regenerate-media     Regenerate media version file
  regenerate-all       Regenerate skin, js and media version file
  help      This help
USAGE;
    }
}

$shell = new Mage_Shell_Compiler();
$shell->run();
