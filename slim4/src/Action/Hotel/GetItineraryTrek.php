<?php

namespace App\Action\Treks;

use App\Domain\Treks\Treks;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetItineraryTrek
{
  private $Treks;
  public function __construct(Treks $Treks)
  {
    $this->Treks = $Treks;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response, $args 
  ): ResponseInterface
  {
    $Treks = $this->Treks->getItineraryTrek($args);
    $response->getBody()->write((string)json_encode($Treks));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}