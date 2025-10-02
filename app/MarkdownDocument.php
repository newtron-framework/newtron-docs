<?php
declare(strict_types=1);

namespace Newtron\App;

use Symfony\Component\Yaml\Yaml;
use Parsedown;

class MarkdownDocument extends Parsedown {
  public string $title;
  public string $description;
  public string $content;
  public array $toc = [];

  public function __construct(string $file) {
    $fileContent = file_get_contents($file);

    if (strpos($fileContent, "---\n") === 0) {
      $parts = explode("\n---\n", $fileContent, 2);
      $frontmatter = Yaml::parse(substr($parts[0], 4));
      $this->description = $frontmatter['description'] ?: null;
      $this->content = $this->text($parts[1] ?? "");
    } else {
      $this->content = $this->text($fileContent);
    }
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
