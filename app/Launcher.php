<?php
declare(strict_types=1);

namespace Newtron\App;

use Newtron\Core\Application\App;

class Launcher {
  // Use this method to run any custom initialization
  public static function setup(): void {
    $am = App::getAssetManager();
    $am->registerStylesheet('global', '/style.css');
    $am->useStylesheet('global');
  }
}
