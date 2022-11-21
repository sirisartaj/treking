<?php
namespace App\Action;

use App\Domain\AdminRoles\Service\AdminRoles;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetPrivileges
{
  private $adminRoles;
  public function __construct(AdminRoles $adminRoles)
  {
    $this->adminRoles = $adminRoles;
  }
  public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response, $args
    ): ResponseInterface 
  {
    $previleges = $this->adminRoles->getPrivileges($args);    
    if($previleges != '')
    {
      $previleges['add'] = explode(',', $previleges['add']);
      $previleges['access'] = explode(',', $previleges['access']);
      $previleges['edit'] = explode(',', $previleges['edit']);
      $previleges['delete'] = explode(',', $previleges['delete']);
      $previleges['status'] = explode(',', $previleges['status']);
      $res = array(
            'status' => "200",
            'message' => "Success",
            'previleges' => $previleges);
    }
    else
    {
      $res = array(
            'status' => "204",
            'message' => "No Data Found"
            );
    }
    $response->getBody()->write((string)json_encode($res));
    return $response
            ->withHeader('Content-Type', 'application/json');

  }
}