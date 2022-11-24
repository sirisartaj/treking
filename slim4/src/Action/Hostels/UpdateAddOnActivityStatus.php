<?php

namespace App\Action\LeisurePackages;

use App\Domain\LeisurePackages\LeisurePackages;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UpdateAddOnActivityStatus
{
  private $leisurePackages;
  public function __construct(LeisurePackages $leisurePackages)
  {
    $this->leisurePackages = $leisurePackages;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
  ): ResponseInterface 
  {
     $data = $request->getParsedBody();
    $data =(array) json_decode($data);
    //$data = array_merge($_POST, $_FILES);
    $leisurePackages = $this->leisurePackages->updateAddOnActivityStatus($data);
    $response->getBody()->write((string)json_encode($leisurePackages));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}