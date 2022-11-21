<?php

namespace App\Action\CelebrityTrips;

use App\Domain\CelebrityTrips\CelebrityTrips;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AddTrip
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
     // $data = $request->getParsedBody();
    // $data =(array) json_decode($data);
    $data = array_merge($_POST, $_FILES);
    $celebrityTrips = $this->celebrityTrips->addTrip($data);
    $response->getBody()->write((string)json_encode($celebrityTrips));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}