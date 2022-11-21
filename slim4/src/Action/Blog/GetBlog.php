<?php
namespace App\Action\Blog;

use App\Domain\Blog\Blog;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetBlog
{
  private $blog;
  public function __construct(Blog $blog)
  {
    $this->blog = $blog;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response, $args
  ): ResponseInterface 
  {
    $blog = $this->blog->getBlog($args);
    $response->getBody()->write((string)json_encode($blog));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}