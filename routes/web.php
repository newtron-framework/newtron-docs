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

  $title = $md->title . ' | Newtron Docs' ?? 'Newtron Docs';
  $desc = $md->description ?? 'Learn Newtron: routing, templates, forms, database, and everything else you need to build something great.';

  App::getDocument()
    ->setTitle($title)
    ->setDescription($desc)
    ->setOG('url', 'https://docs.newtron.app' . $request->getPath())
    ->setOG('type', 'website')
    ->setOG('title', $title)
    ->setOG('description', $desc)
    ->setOG('image', 'https://docs.newtron.app/images/newtron-og.jpg')
    ->setOG('image:width', '1200')
    ->setOG('image:height', '630')
    ->setMeta('twitter:card', 'summary_large_image')
    ->setMeta('twitter:domain', 'docs.newtron.app', 'property')
    ->setMeta('twitter:url', 'https://docs.newtron.app' . $request->getPath(), 'property')
    ->setMeta('twitter:title', $title)
    ->setMeta('twitter:description', $desc)
    ->setMeta('twitter:image', 'https://docs.newtron.app/images/newtron-og.jpg');

  return Response::create(
    Quark::render('layout', [
      'content' => $md->content,
      'toc' => $md->toc,
      'markdownPath' => $request->getPath() . '.md',
    ])
  );
});
