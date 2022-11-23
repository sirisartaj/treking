<?php

namespace App\Action\Expeditions;

use App\Domain\Expeditions\Expeditions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DeleteExpedition
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
    $data = $request->getBody();
    $data =(array) json_decode($data);
    
    $Expeditions = $this->Expeditions->deleteExpedition($data);
    $response->getBody()->write((string)json_encode($Expeditions));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}