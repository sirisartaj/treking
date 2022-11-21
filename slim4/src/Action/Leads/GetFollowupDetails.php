<?php
namespace App\Action\Leads;

use App\Domain\Leads\Leads;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetFollowupDetails
{
  private $leads;
  public function __construct(Leads $leads)
  {
    $this->leads = $leads;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response, $args
  ): ResponseInterface 
  {
    $leads = $this->leads->getFollowupDetails($args);
    $response->getBody()->write((string)json_encode($leads));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}