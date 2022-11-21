<?php

namespace App\Action\Blog;

use App\Domain\Blog\Blog;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AddBlogArticle
{
  private $blog;
  public function __construct(Blog $blog)
  {
    $this->blog = $blog;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
  ): ResponseInterface 
  {
     // $data = $request->getParsedBody();
    // $data =(array) json_decode($data);
    $data = array_merge($_POST, $_FILES);
    $blog = $this->blog->addBlogArticle($data);
    $response->getBody()->write((string)json_encode($blog));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}