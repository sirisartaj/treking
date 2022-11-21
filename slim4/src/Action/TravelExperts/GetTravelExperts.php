<?php

namespace App\Action\TravelExperts;

use App\Domain\TravelExperts\TravelExperts;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetTravelExperts
{
  private $travelExperts;
  public function __construct(TravelExperts $travelExperts)
  {
    $this->travelExperts = $travelExperts;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
  ): ResponseInterface 
  {
    $travelExperts = $this->travelExperts->getTravelExperts();
    $response->getBody()->write((string)json_encode($travelExperts));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}