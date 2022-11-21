<?php

namespace App\Action\Organizers;

use App\Domain\Organizers\Organizers;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UpdateTripOrganizerStatus
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
    $data = $request->getBody();
    $data =(array) json_decode($data);
    $organizers = $this->organizers->updateTripOrganizerStatus($data);
    $response->getBody()->write((string)json_encode($organizers));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}