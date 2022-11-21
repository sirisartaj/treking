<?php
namespace App\Action\ContactUs;

use App\Domain\ContactUs\ContactUs;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetTrekBookingEnq
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
    $contactUs = $this->contactUs->getTrekBookingEnq();
    $response->getBody()->write((string)json_encode($contactUs));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}