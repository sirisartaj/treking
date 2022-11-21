<?php

namespace App\Action\CelebrityTrips;

use App\Domain\CelebrityTrips\CelebrityTrips;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetTripEnquiries
{
  private $CelebrityTrips;
  public function __construct(CelebrityTrips $celebrityTrips)
  {
    $this->celebrityTrips = $celebrityTrips;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
  ): ResponseInterface 
  {
    $celebrityTrips = $this->celebrityTrips->getTripEnquiries();
    $response->getBody()->write((string)json_encode($celebrityTrips));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}