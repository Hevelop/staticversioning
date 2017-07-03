<?php

/**
 * Class Hevelop_StaticVersioning_Helper_Data
 *
 * @package  Hevelop_StaticVersioning
 * @author   Alessandro Pagnin <alessandro@hevelop.com>
 * @license  https://opensource.org/licenses/agpl-3.0  GNU Affero General Public License (AGPL 3.0)
 */
class Hevelop_StaticVersioning_Helper_Data extends Mage_Core_Helper_Data
{
    public function isActive() {
        return Mage::getStoreConfigFlag('hevelop_staticversioning/general/activate');
    }
}