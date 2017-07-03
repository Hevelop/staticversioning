<?php

/**
 * Class Hevelop_StaticVersioning_Model_Store
 *
 * @package  Hevelop_StaticVersioning
 * @author   Alessandro Pagnin <alessandro@hevelop.com>
 * @license  https://opensource.org/licenses/agpl-3.0  GNU Affero General Public License (AGPL 3.0)
 */
class Hevelop_StaticVersioning_Model_Store extends Mage_Core_Model_Store
{
    const PATH_PREFIX = 'version';
    const VERSIONING_FILE = 'version.txt';

    public function getBaseUrl($type = self::URL_TYPE_LINK, $secure = null, $versioning_media=false)
    {
        if (!Mage::helper('hevelop_staticversioning')->isActive()) {
            return parent::getBaseUrl($type, $secure);
        }
        $baseCacheKey = $type . '/' . (is_null($secure) ? 'null' : ($secure ? 'true' : 'false'));
        $cacheKey = self::URL_TYPE_MEDIA == $type ? ($baseCacheKey . '_' . ($versioning_media ? 'wv' : 'wov')) : $baseCacheKey;
        if (!isset($this->_baseUrlCache[$cacheKey])) {
            $base_url = parent::getBaseUrl($type, $secure);

            // Add version folder
            $versioning_path = false;
            switch ($type) {
                case self::URL_TYPE_JS:
                    $versioning_path = rtrim(Mage::getBaseDir(), '/') . '/js/' . self::VERSIONING_FILE;
                    break;
                case self::URL_TYPE_SKIN:
                    $versioning_path = rtrim(Mage::getBaseDir($type), '/') . '/' . self::VERSIONING_FILE;
                    break;
                case self::URL_TYPE_MEDIA:
                    if ($versioning_media) {
                        $versioning_path = rtrim(Mage::getBaseDir($type), '/') . '/' . self::VERSIONING_FILE;
                    }
                    break;
            }

            if (!empty($versioning_path)) {
                if (file_exists($versioning_path) && !empty(file_get_contents($versioning_path))) {
                    $v = file_get_contents($versioning_path);
                } else {
                    $v = time();
                    file_put_contents($versioning_path, (string) $v);
                }
                $this->_baseUrlCache[$cacheKey] = $base_url . self::PATH_PREFIX . $v . '/';
            } else {
                $this->_baseUrlCache[$cacheKey] = $base_url;
            }
        }

        return $this->_baseUrlCache[$cacheKey];
    }
}

