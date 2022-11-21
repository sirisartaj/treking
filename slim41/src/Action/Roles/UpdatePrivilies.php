<?php

namespace App\Action\Roles;

use App\Domain\Roles\Roles;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UpdatePrivilies
{
  private $Roles;
  public function __construct(Roles $Roles)
  {
    $this->Roles = $Roles;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
  ): ResponseInterface 
  {
      $data = $request->getBody();
     $data =(array) json_decode($data);
    $data = array_merge($data, $_FILES);
    $Roles = $this->Roles->updatePrivilies($data);
    $response->getBody()->write((string)json_encode($Roles));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}