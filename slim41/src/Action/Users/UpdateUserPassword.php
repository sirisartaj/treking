<?php
namespace App\Action\Users;

use App\Domain\Users\Users;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UpdateUserPassword
{
  private $Users;
  public function __construct(Users $users)
  {
    $this->users = $users;
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
    //$data = array_merge($data, $_FILES);
   // print_r($data);exit;
    $users = $this->users->updateUserPassword($data);
    $response->getBody()->write((string)json_encode($users));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}