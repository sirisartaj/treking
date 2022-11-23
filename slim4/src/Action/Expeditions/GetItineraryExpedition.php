<?php

namespace App\Action\Expeditions;

use App\Domain\Expeditions\Expeditions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetItineraryExpedition
{
  private $Expeditions;
  public function __construct(Expeditions $Expeditions)
  {
    $this->Expeditions = $Expeditions;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response, $args 
  ): ResponseInterface
  {
    $Expeditions = $this->Expeditions->getItineraryExpedition($args);
    $response->getBody()->write((string)json_encode($Expeditions));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}