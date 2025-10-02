<?php
declare(strict_types=1);

namespace Newtron\App;

use Newtron\Core\Application\App;
use Newtron\Core\Quark\QuarkEngine;

class Launcher {
  // Use this method to run any custom initialization
  public static function setup(): void {
    $am = App::getAssetManager();
    $am->registerStylesheet('fonts', '/fonts.css');
    $am->useStylesheet('fonts');
    $am->registerStylesheet('global', '/style.css');
    $am->useStylesheet('global');
    $am->registerStylesheet('font-awesome', 'https://kit.fontawesome.com/2f00f14f95.css');
    $am->useStylesheet('font-awesome');
    $am->registerStylesheet('prism', '/prism.css');
    $am->useStylesheet('prism');
    $am->registerScript('prism', '/prism.js');
    $am->useScript('prism');
    $am->registerStylesheet('prism-dracula', '/prism-dracula.css');
    $am->useStylesheet('prism-dracula');

    $sidebar = require NEWTRON_ROOT . '/app/SidebarStructure.php';
    $quark = App::getContainer()->get(QuarkEngine::class);
    $quark->addGlobal('structure', $sidebar);
  }
}
