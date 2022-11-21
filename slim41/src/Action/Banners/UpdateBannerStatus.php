<?php

namespace App\Action\Banners;

use App\Domain\Banners\Banners;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UpdateBannerStatus
{
  private $Banners;
  public function __construct(Banners $banners)
  {
    $this->banners = $banners;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
  ): ResponseInterface 
  {
     $data = $request->getParsedBody();
    $data =(array) json_decode($data);
    $banners = $this->banners->updateBannerStatus($data);
    $response->getBody()->write((string)json_encode($banners));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}