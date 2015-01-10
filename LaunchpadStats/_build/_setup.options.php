<?php
$output = '';
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
        break;
    case xPDOTransport::ACTION_UPGRADE:
 		 $setting = $modx->getObject('modSystemSetting',array('key' => 'ludwiglaunchpadstats.version'));
		if ($setting != null) { 
				$setting->set('value','1.0.0');
				$setting->save();
		}
        unset($setting);
    case xPDOTransport::ACTION_UNINSTALL:
        break;
}
return $output;
