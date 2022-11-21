<?php

namespace App\Action\Roles;

use App\Domain\Roles\Roles;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetRole
{
  private $Roles;
  public function __construct(Roles $Roles)
  {
    $this->Roles = $Roles;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response, $args
  ): ResponseInterface 
  {
    $Roles = $this->Roles->getRole($args);
    $response->getBody()->write((string)json_encode($Roles));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}