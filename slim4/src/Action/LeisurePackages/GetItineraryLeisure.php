<?php

namespace App\Action\LeisurePackages;

use App\Domain\LeisurePackages\LeisurePackages;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetItineraryLeisure
{
  private $LeisurePackages;
  public function __construct(LeisurePackages $LeisurePackages)
  {
    $this->LeisurePackages = $LeisurePackages;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response, $args 
  ): ResponseInterface
  {
    $LeisurePackages = $this->LeisurePackages->getItineraryLeisure($args);
    $response->getBody()->write((string)json_encode($LeisurePackages));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}