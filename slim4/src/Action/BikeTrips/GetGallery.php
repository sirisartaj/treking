<?php
namespace App\Action\BikeTrips;

use App\Domain\BikeTrips\BikeTrips;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetGallery
{
  private $bikeTrips;
  public function __construct(BikeTrips $bikeTrips)
  {
    $this->bikeTrips = $bikeTrips;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response, $args 
  ): ResponseInterface
  {
    $bikeTrips = $this->bikeTrips->getGallery($args);
    $response->getBody()->write((string)json_encode($bikeTrips));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}