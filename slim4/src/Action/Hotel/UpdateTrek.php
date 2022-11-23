<?php

namespace App\Action\Treks;

use App\Domain\Treks\Treks;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UpdateTrek
{
  private $Treks;
  public function __construct(Treks $Treks)
  {
    $this->Treks = $Treks;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
  ): ResponseInterface 
  {
      $data = $request->getBody();
     // print_r($data);echo "sds";exit;
     $data =(array) json_decode($data);
     //print_r($data);exit;
    //$data = array_merge($data, $_FILES);
    $Treks = $this->Treks->updateTrek($data);
    $response->getBody()->write((string)json_encode($Treks));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}