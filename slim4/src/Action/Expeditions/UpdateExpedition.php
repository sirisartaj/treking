<?php

namespace App\Action\Expeditions;

use App\Domain\Expeditions\Expeditions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UpdateExpedition
{
  private $expeditions;
  public function __construct(Expeditions $expeditions)
  {
    $this->expeditions = $expeditions;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
  ): ResponseInterface 
  {
      $data = $request->getBody();
     $data =(array) json_decode($data);
    
    //$data = array_merge($_POST, $_FILES);
    $expeditions = $this->expeditions->updateExpedition($data);
    $response->getBody()->write((string)json_encode($expeditions));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}