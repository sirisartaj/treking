<?php
namespace App\Domain\Pages;

use App\Domain\Pages\PagesRepository;
use App\Exception\ValidationException;
use App\Utilities\ImageUpload;

/**
 * Service.
 */
final class Pages
{
  /**
   * @var BannersRepository
   */
  private $repository;
  /**
   * The constructor.
   *
   * @param BannersRepository $repository The repository
   */
  public function __construct(PagesRepository $repository)
  {
    $this->repository = $repository;
  }
  public function getPages() {
    $pages = $this->repository->getPages();
    return $pages;
  }
  public function getPageDetails($data) {
    $pages = $this->repository->getPageDetails($data);
    return $pages;
  }
  public function updatePage($data) {
    $pages = $this->repository->updatePage($data);
    return $pages;
  }
}