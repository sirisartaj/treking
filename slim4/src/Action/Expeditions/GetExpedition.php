<?php

namespace App\Action\Expeditions;

use App\Domain\Expeditions\Expeditions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetExpedition
{
  private $expeditions;
  public function __construct(Expeditions $expeditions)
  {
    $this->expeditions = $expeditions;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response, $args 
  ): ResponseInterface
  {
    
    $expeditions = $this->expeditions->getExpedition($args);
    $response->getBody()->write((string)json_encode($expeditions));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}