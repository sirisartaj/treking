<?php

namespace App\Action\Rentals;

use App\Domain\Rentals\Rentals;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DeleteRentalItem
{
  private $rentals;
  public function __construct(Rentals $rentals)
  {
    $this->rentals = $rentals;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response, $args
  ): ResponseInterface 
  {
    $rentals = $this->rentals->deleteRentalItem($args);
    $response->getBody()->write((string)json_encode($rentals));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}