<?php
namespace App\Action\Videos;

use App\Domain\Videos\Videos;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetVideos
{
  private $videos;
  public function __construct(Videos $videos)
  {
    $this->videos = $videos;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
  ): ResponseInterface 
  {
    $videos = $this->videos->getVideos();
    $response->getBody()->write((string)json_encode($videos));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}