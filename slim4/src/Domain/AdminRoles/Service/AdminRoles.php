<?php
namespace App\Domain\AdminRoles\Service;

use App\Domain\AdminRoles\Repository\AdminRolesRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class AdminRoles
{
  /**
   * @var AdminRolesRepository
   */
  private $repository;
  /**
   * The constructor.
   *
   * @param AdminRolesRepository $repository The repository
   */
  public function __construct(AdminRolesRepository $repository)
  {
    $this->repository = $repository;
  }
  /**
   * Create a new user.
   *
   * @param array $data The form data
   *
   * @return int The new user ID
   */
  public function getAdminRoles(): array
  {        
    $adminRoles = $this->repository->getAdminRoles();
    return $adminRoles;
  }
  /**
   * Create a new user.
   *
   * @param array $data The form data
   *
   * @return int The new user ID
   */
  public function getAdminRole($args): array
  {        
    $adminRole = $this->repository->getAdminRole($args);
    return $adminRole;
  }
  public function addAdminRole(array $data): array
  {
    // Input validation
    //$this->validateAdminRole($data);
    $errors = [];
    // Here you can also use your preferred validation library
    if (empty($data['roleName'])) {
        $errors['roleName'] = 'Role Name is required';
    }
    if ($errors) {
       $status = array(
            'status' => "500",
            'message' => $errors['roleName']);
      return $status;
    }
    // Insert user
    $roleId = $this->repository->insertAdminRole($data);
    // Logging here: User created successfully
    //$this->logger->info(sprintf('User created successfully: %s', $userId));
    return $roleId;
  }
  public function updateAdminRole(array $data): array
  {
    // Input validation
    //$this->validateAdminRole($data);
    $errors = [];
    // Here you can also use your preferred validation library
    if (empty($data['roleName'])) {
        $errors['roleName'] = 'Role Name is required';
    }
    if ($errors) {
       $status = array(
            'status' => "500",
            'message' => $errors['roleName']);
      return $status;
    }
    // Insert user
    $roleId = $this->repository->updateAdminRole($data);
    // Logging here: User created successfully
    //$this->logger->info(sprintf('User created successfully: %s', $userId));
    return $roleId;
  }
  public function DeleteAdminRole(array $data): array{
    $roleId = $this->repository->deleteAdminRole($data);
    return $roleId;
  }
  private function validateAdminRole(array $data): void
  {
    $errors = [];
    // Here you can also use your preferred validation library
    if (empty($data['roleName'])) {
        $errors['roleName'] = 'Role Name is required';
    }
    if ($errors) {
        throw new ValidationException('Please check your input', $errors,201);
    }
  }
  public function getPrivileges($args): array
  {        
    $adminRole = $this->repository->getPrivileges($args);
    return $adminRole;
  }
  public function editPrivileges(array $data): array
  {
    $roleId = $this->repository->editPrivileges($data);
    return $roleId;
  }
  public function updateRoleStatus($data) {
    $role = $this->repository->updateRoleStatus($data);
    return $role;
  }
}