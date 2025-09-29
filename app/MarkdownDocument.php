<?php
declare(strict_types=1);

namespace Newtron\App;

use Parsedown;

class MarkdownDocument extends Parsedown {
  public string $title;
  public string $content;
  public array $toc;

  public function __construct(string $file) {
    $this->content = $this->text(file_get_contents($file));
  }

  protected function blockHeader($Line) {
    $Block = parent::blockHeader($Line);

    if (isset($Block['element']['name'])) {
      if ($Block['element']['name'] === 'h1') {
        $this->title = $Block['element']['text'];
      } elseif ($Block['element']['name'] === 'h2') {
        $id = strtolower(preg_replace('/[^a-zA-Z0-9\-]+/', '-', $Block['element']['text']));
        $Block['element']['attributes']['id'] = $id;
        $this->toc[] = [
          'text' => $Block['element']['text'],
          'id' => $id,
        ];
      }
    }

    return $Block;
  }
}
