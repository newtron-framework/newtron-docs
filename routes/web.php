<?php
declare(strict_types=1);

use Newtron\App\MarkdownDocument;
use Newtron\Core\Application\App;
use Newtron\Core\Error\HttpException;
use Newtron\Core\Http\Request;
use Newtron\Core\Http\Response;
use Newtron\Core\Http\Status;
use Newtron\Core\Quark\Quark;
use Newtron\Core\Routing\Route;

Route::get('*', function (Request $request) {
  $mdFile = NEWTRON_ROOT . '/docs' . $request->getPath() . '.md';
  if (!file_exists($mdFile)) {
    $mdFile = substr($mdFile, 0, -3) . '/_index.md';
    if (!file_exists($mdFile)) {
      throw new HttpException(Status::NOT_FOUND, $mdFile);
    }
  }

  $md = new MarkdownDocument($mdFile);

  App::getDocument()->setTitle($md->title ?? 'Newtron Docs');

  return Response::create(
    Quark::render('article', ['content' => $md->content])
  );
});
