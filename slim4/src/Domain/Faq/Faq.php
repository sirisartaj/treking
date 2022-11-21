<?php
namespace App\Domain\Faq;

use App\Domain\Faq\FaqRepository;
use App\Exception\ValidationException;
use App\Utilities\ImageUpload;

/**
 * Service.
 */
final class Faq
{
  /**
   * @var FaqRepository
   */
  private $repository;
  /**
   * The constructor.
   *
   * @param FaqRepository $repository The repository
   */
  public function __construct(FaqRepository $repository)
  {
    $this->repository = $repository;
  }
  public function getFaqCategories(): array
  {        
    $Faq = $this->repository->getFaqCategories();
    return $Faq;
  }
}