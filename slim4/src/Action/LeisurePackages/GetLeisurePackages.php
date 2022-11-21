<?php

namespace App\Action\LeisurePackages;

use App\Domain\LeisurePackages\LeisurePackages;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetLeisurePackages
{
  private $leisurePackages;
  public function __construct(LeisurePackages $leisurePackages)
  {
    $this->leisurePackages = $leisurePackages;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
  ): ResponseInterface 
  {
    $leisurePackages = $this->leisurePackages->getLeisurePackages();
    $response->getBody()->write((string)json_encode($leisurePackages));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}