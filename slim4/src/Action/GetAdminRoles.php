<?php

namespace App\Action;

use App\Domain\AdminRoles\Service\AdminRoles;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetAdminRoles
{
  private $adminRoles;
  public function __construct(AdminRoles $adminRoles)
  {
    $this->adminRoles = $adminRoles;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
  ): ResponseInterface 
  {
    $adminRoles = $this->adminRoles->getAdminRoles();
    $response->getBody()->write((string)json_encode($adminRoles));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}