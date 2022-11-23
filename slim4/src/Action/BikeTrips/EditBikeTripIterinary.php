<?php

namespace App\Action\BikeTrips;

use App\Domain\BikeTrips\BikeTrips;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EditBikeTripIterinary
{
  private $BikeTrips;
  public function __construct(BikeTrips $BikeTrips)
  {
    $this->BikeTrips = $BikeTrips;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
  ): ResponseInterface 
  {
      $data = $request->getBody();
     $data =(array) json_decode($data);
    //$data = array_merge($_POST, $_FILES);
    // print_r($data);exit;
    $BikeTrips = $this->BikeTrips->editBikeTripIterinary($data);
    $response->getBody()->write((string)json_encode($BikeTrips));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}