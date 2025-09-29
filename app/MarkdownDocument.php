<?php
declare(strict_types=1);

namespace Newtron\App;

use Parsedown;

class MarkdownDocument extends Parsedown {
  public string $title;
  public string $content;

  public function __construct(string $file) {
    $this->content = $this->text(file_get_contents($file));
  }

  protected function blockHeader($Line) {
    $Block = parent::blockHeader($Line);

    if (isset($Block['element']['name']) && $Block['element']['name'] === 'h1') {
      $this->title = $Block['element']['text'];
    }

    return $Block;
  }
}
