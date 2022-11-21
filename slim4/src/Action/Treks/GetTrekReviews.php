<?php

namespace App\Action\Treks;

use App\Domain\Treks\Treks;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetTrekReviews
{
  private $treks;
  public function __construct(Treks $treks)
  {
    $this->treks = $treks;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
  ): ResponseInterface
  {
    $treks = $this->treks->getTrekReviews();
    $response->getBody()->write((string)json_encode($treks));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}