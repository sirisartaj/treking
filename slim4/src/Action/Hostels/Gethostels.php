<?php

namespace App\Action\Hostel;

use App\Domain\Hostel\Hostel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Gethostels
{
  private $hostel;
  public function __construct(Hostel $hostel)
  {
    $this->hostel = $hostel;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
  ): ResponseInterface 
  {
    $hostel = $this->hostel->getHostel();
    $response->getBody()->write((string)json_encode($hostel));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}