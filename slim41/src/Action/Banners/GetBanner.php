<?php

namespace App\Action\Banners;

use App\Domain\Banners\Banners;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetBanner
{
  private $banners;
  public function __construct(Banners $banners)
  {
    $this->banners = $banners;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response, $args
  ): ResponseInterface 
  {
    $banners = $this->banners->getBanner($args);
    $response->getBody()->write((string)json_encode($banners));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}