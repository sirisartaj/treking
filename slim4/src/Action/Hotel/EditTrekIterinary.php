<?php

namespace App\Action\Treks;

use App\Domain\Treks\Treks;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EditTrekIterinary
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
     $data =(array) json_decode($data);
    //$data = array_merge($_POST, $_FILES);
    // print_r($data);exit;
    $Treks = $this->Treks->editTrekIterinary($data);
    $response->getBody()->write((string)json_encode($Treks));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}