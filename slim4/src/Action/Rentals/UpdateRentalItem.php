<?php

namespace App\Action\Rentals;

use App\Domain\Rentals\Rentals;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UpdateRentalItem
{
  private $rentals;
  public function __construct(Rentals $rentals)
  {
    $this->rentals = $rentals;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
  ): ResponseInterface 
  {
     // $data = $request->getParsedBody();
    // $data =(array) json_decode($data);
    $data = array_merge($_POST, $_FILES);
    $rentals = $this->rentals->updateRentalItem($data);
    $response->getBody()->write((string)json_encode($rentals));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}