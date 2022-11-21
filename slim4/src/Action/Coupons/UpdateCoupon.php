<?php

namespace App\Action\Coupons;

use App\Domain\Coupons\Coupons;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UpdateCoupon
{
  private $coupons;
  public function __construct(Coupons $coupons)
  {
    $this->coupons = $coupons;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
  ): ResponseInterface 
  {
    $data = $request->getBody();
    $data =(array) json_decode($data);
    $coupons = $this->coupons->updateCoupon($data);
    $response->getBody()->write((string)json_encode($coupons));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}