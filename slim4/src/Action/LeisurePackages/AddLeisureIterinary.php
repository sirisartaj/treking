<?php

namespace App\Action\LeisurePackages;

use App\Domain\LeisurePackages\LeisurePackages;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AddLeisureIterinary
{
  private $LeisurePackages;
  public function __construct(LeisurePackages $LeisurePackages)
  {
    $this->LeisurePackages = $LeisurePackages;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
  ): ResponseInterface 
  {
      $data = $request->getBody();
     $data =(array) json_decode($data);
    //$data = array_merge($_POST, $_FILES);
    // print_r($data);exit;
    $LeisurePackages = $this->LeisurePackages->addLeisureIterinary($data);
    $response->getBody()->write((string)json_encode($LeisurePackages));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}