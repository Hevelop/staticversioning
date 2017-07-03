Hevelop Static Resources Versioning for Magento 1.x
=====================

This module is inspired by the magento2 versioning system and rewrite the skin, js and media (only minified js and css) urls by prepending to them a versionXXXXX string.

Examples:

- /skin/frontend/base/default/braintree/css/braintree.css -> /skin/version1499078126/frontend/base/default/braintree/css/braintree.css
- /js/varien/form.js -> /js/version1499078126/varien/form.js

Requirements
------------
- PHP >= 5.5.0

Compatibility
-------------
- Magento >= 1.9.0.1;
- This module rewrite Mage_Core_Model_Store and Mage_Core_Model_Design_Package; it could have compatibility problems
  with other packages;
- Includes support of the Aoe DesignFallback module. 

Installation Instructions
-------------------------
1. Install the extension via modman, composer or copy all the files into your document root.
2. Clear the cache, logout from the admin panel and then login again.
3. Activate the extension under System - Configuration - Hevelop - Static Versioning.

**BE CAREFUL, DRAGONS AHEAD:**

To complete the installation of the module you have to copy the following files from the extension to your magento root:

- src/skin/.htaccess -> MAGENTO_ROOT/skin/.htaccess
- src/js/.htaccess -> MAGENTO_ROOT/js/.htaccess
- src/media/.htaccess -> MAGENTO_ROOT/media/.htaccess

If your are using modman, the first two files are linked automatically, but **not the last one**, to avoid problems with complex deployment setup where the media folder is a linked folder.

Usage
------
After the deployment of new static resources (skin files/css/js) you can change the versioning url path using the shell command htdocs/shell/hevelop_staticversioning_clearversion.php.

Uninstallation
--------------
1. Remove all extension files from your Magento installation

Developer
---------
Alessandro Pagnin @ [http://hevelop.com](http://hevelop.com)

Licence
-------
[GNU AFFERO GENERAL PUBLIC LICENSE 3.0](https://www.gnu.org/licenses/agpl-3.0.en.html)

Copyright
---------
(c) 2017 Hevelop
