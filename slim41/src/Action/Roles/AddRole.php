<?php
namespace App\Action\Roles;

use App\Domain\Roles\Roles;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AddRole
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
      //$data = $request->getParsedBody();
     //$data =(array) json_decode($data);

     $data = $request->getBody();
    $data =(array) json_decode($data);

    //print_r($data);exit;
    $data = array_merge($data, $_FILES);
   // print_r($data);exit;
    $Roles = $this->Roles->addRole($data);
    $response->getBody()->write((string)json_encode($Roles));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}