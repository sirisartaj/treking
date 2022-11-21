<?php
namespace App\Action;

use App\Domain\AdminRoles\Service\AdminRoles;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AddAdminRole
{
  private $adminRoles;
  public function __construct(AdminRoles $adminRoles)
  {
    $this->adminRoles = $adminRoles;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
  ): ResponseInterface {
    $data = $request->getBody();
    $data =(array) json_decode($data);
    // Invoke the Domain with inputs and retain the result
    $adminRoles = $this->adminRoles->addAdminRole($data);
    $response->getBody()->write((string)json_encode($adminRoles));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}