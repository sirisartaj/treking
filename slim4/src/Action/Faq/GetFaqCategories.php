<?php

namespace App\Action\Faq;

use App\Domain\Faq\Faq;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetFaqCategories
{
  private $faq;
  public function __construct(Faq $faq)
  {
    $this->faq = $faq;
  }
  public function __invoke(
      ServerRequestInterface $request, 
      ResponseInterface $response
  ): ResponseInterface 
  {
    $faq = $this->faq->getFaqCategories();
    $response->getBody()->write((string)json_encode($faq));
    return $response
          ->withHeader('Content-Type', 'application/json');
  }
}