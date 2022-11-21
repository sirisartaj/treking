<?php
namespace App\Action\Videos;

use App\Domain\Videos\Videos;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DeleteVideo
{
  private $videos;
  public function __construct(Videos $videos)
  {
    $this->videos = $videos;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response, $args
  ): ResponseInterface 
  {
    $videos = $this->videos->deleteVideo($args);
    $response->getBody()->write((string)json_encode($videos));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}