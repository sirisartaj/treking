<?php

namespace App\Action\ContactUs;

use App\Domain\ContactUs\ContactUs;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UpdateContactUs
{
  private $contactUs;
  public function __construct(ContactUs $contactUs)
  {
    $this->contactUs = $contactUs;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
  ): ResponseInterface 
  {
    $data = $request->getBody();
    $data =(array) json_decode($data);
    $contactUs = $this->contactUs->updateContactUs($data);
    $response->getBody()->write((string)json_encode($contactUs));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}