<?php

namespace App\Action\BikeTrips;

use App\Domain\BikeTrips\BikeTrips;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetBikeItineraryTrip
{
  private $BikeTrips;
  public function __construct(BikeTrips $BikeTrips)
  {
    $this->BikeTrips = $BikeTrips;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response, $args 
  ): ResponseInterface
  {
    $BikeTrips = $this->BikeTrips->getItineraryBikeTrip($args);
    $response->getBody()->write((string)json_encode($BikeTrips));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}