<?php

namespace App\Action\Promotions;

use App\Domain\Promotions\Promotions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UpdatePromotion
{
  private $promotions;
  public function __construct(Promotions $promotions)
  {
    $this->promotions = $promotions;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
  ): ResponseInterface 
  {
    $data = $request->getBody();
    $data =(array) json_decode($data);
    $promotions = $this->promotions->updatePromotion($data);
    $response->getBody()->write((string)json_encode($promotions));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}