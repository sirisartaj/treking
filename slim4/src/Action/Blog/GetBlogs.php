<?php
namespace App\Action\Blog;

use App\Domain\Blog\Blog;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetBlogs
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
    $blog = $this->blog->getBlogs();
    $response->getBody()->write((string)json_encode($blog));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}