<?php

namespace App\Action\Hostels;

use App\Domain\Hostels\Hostels;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AddHostelGallery
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
    // $data = $request->getParsedBody();
    // $data =(array) json_decode($data);
    $data = array_merge($_POST, $_FILES);
    $hostels = $this->hostels->addHostelGallery($data);
    $response->getBody()->write((string)json_encode($hostels));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}