<?php

namespace App\Action\Promotions;

use App\Domain\Promotions\Promotions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetPromotion
{
  private $promotions;
  public function __construct(Promotions $promotions)
  {
    $this->promotions = $promotions;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response, $args
  ): ResponseInterface 
  {
    $promotions = $this->promotions->getPromotion($args);
    $response->getBody()->write((string)json_encode($promotions));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}