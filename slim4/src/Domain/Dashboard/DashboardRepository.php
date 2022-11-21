<?php
namespace App\Domain\Dashboard;
use PDO;
/**
* Repository.
*/
class DashboardRepository
{
  /**
   * @var PDO The database connection
   */
  private $connection;
  /**
   * Constructor.
   *
   * @param PDO $connection The database connection
   */
  public function __construct(PDO $connection)
  {
    $this->connection = $connection;
  }
  /**
   * Get Admin Roles rows.
   *
   * @return array 
   */
  public function getDashboard(): array
  {      
    try {
      $query = "SELECT count(`user_id`) as userscnt FROM sg_users WHERE `user_status`='0'";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $result['users'] = $stmt->fetch(PDO::FETCH_ASSOC);
      $query2 = "SELECT count(`trek_id`) as trekscnt FROM sg_trekingdetails WHERE `status`='0'";
      $stmt2 = $this->connection->prepare($query2);
      $stmt2->execute();
      $result['treks'] = $stmt2->fetch(PDO::FETCH_ASSOC);
      $query3 = "SELECT count(`form_id`) as enquiries FROM sg_searchformdetails";
      $stmt3 = $this->connection->prepare($query3);
      $stmt3->execute();
      $result['enqcnt'] = $stmt3->fetch(PDO::FETCH_ASSOC);
      $query4 = "SELECT concat(`first_name`,' ',`last_name`) as name,`mobile`,`email`,`address`,`gender` FROM sg_regestration where email!='' and mobile!='' order by registration_id desc LIMIT 5";
      $stmt4 = $this->connection->prepare($query4);
      $stmt4->execute();
      $result['customers'] = $stmt4->fetchAll(PDO::FETCH_ASSOC);
      $query5 = "SELECT DISTINCT(pm.`txn_id`) AS txnId, pm.`payment_id` AS paymentId, pm.`created_date` as txnDate, bb.`buyer_name` AS buyerName, bb.`phone`,pm.`txn_id` AS txnId, pm.`amount`, pm.`payment_type` AS paymentType, gettrekname(b.`trek_id`) AS trekTitle, ib.`trekstart_date` AS trekStartDate, ib.`trekend_date` AS trekEndDate FROM sg_inserttrekbatches ib,sg_beforebookingdetails bb ,sg_paymentdetails pm inner join sg_bookingdetails b on pm.`booking_id` = b.`booking_id` where ib.`batch_id` = b.`batch` and b.`booking_id`=bb.`booking_id` order by pm.`payment_id` desc LIMIT 5";
      $stmt5 = $this->connection->prepare($query5);
      $stmt5->execute();
      $result['transactions'] = $stmt5->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
}