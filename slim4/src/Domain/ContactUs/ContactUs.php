<?php
namespace App\Domain\ContactUs;

use App\Domain\ContactUs\ContactRepository;
use App\Exception\ValidationException;
use App\Utilities\ImageUpload;

/**
 * Service.
 */
final class ContactUs
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
  public function __construct(ContactRepository $repository)
  {
    $this->repository = $repository;
  }
  public function getContactUs(): array
  {        
    $Blog = $this->repository->getContactUs();
    return $Blog;
  }
  public function updateContactUs($data) : array 
  {    
    $res = $this->repository->updateContactUs($data);
    return $res;    
  }
  public function getEnqInfo() {
    $res = $this->repository->getEnqInfo();
    return $res; 
  }
  public function getTrekBookingEnq() {
    $res = $this->repository->getTrekBookingEnq();
    return $res; 
  }
  public function getInTouchDetails() {
    $res = $this->repository->getInTouchDetails();
    return $res; 
  }
  public function getSubscribers() {
    $res = $this->repository->getSubscribers();
    return $res; 
  }
}