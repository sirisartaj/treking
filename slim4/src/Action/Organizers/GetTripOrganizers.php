<?php

namespace App\Action\Organizers;

use App\Domain\Organizers\Organizers;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetTripOrganizers
{
  private $organizers;
  public function __construct(Organizers $organizers)
  {
    $this->organizers = $organizers;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
  ): ResponseInterface 
  {
    $organizers = $this->organizers->getTripOrganizers();
    $response->getBody()->write((string)json_encode($organizers));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}