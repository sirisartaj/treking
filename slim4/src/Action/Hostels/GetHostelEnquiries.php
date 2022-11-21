<?php

namespace App\Action\Hostels;

use App\Domain\Hostels\Hostels;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetHostelEnquiries
{
  private $hostels;
  public function __construct(Hostels $hostels)
  {
    $this->hostels = $hostels;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
  ): ResponseInterface 
  {
    $hostels = $this->hostels->getHostelEnquiries();
    $response->getBody()->write((string)json_encode($hostels));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}