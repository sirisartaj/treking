<?php

namespace App\Action\Banners;

use App\Domain\Banners\Banners;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AddBanner
{
  private $Banners;
  public function __construct(Banners $banners)
  {
    $this->banners = $banners;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
  ): ResponseInterface 
  {
     // $data = $request->getParsedBody();
    // $data =(array) json_decode($data);
    $data = array_merge($_POST, $_FILES);
    print_r($data);exit;
    $banners = $this->banners->addBanner($data);
    $response->getBody()->write((string)json_encode($banners));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}