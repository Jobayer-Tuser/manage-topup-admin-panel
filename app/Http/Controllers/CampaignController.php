<?php

namespace App\Http\Controllers;
use App\Models\Database;

class CampaignController
{
    private object $eloquent;

    public function __construct()
    {
        $this->eloquent = Database::getInstance();
    }

    /**
     * Get the all number from excel and save it to temporary campaign process table.
     *
     * @param array $campaign
     * @param array $contacts
     * @return string
     */
    public function saveTempCampaignDataFromExcel( array $campaign, array $contacts ): string
    {
        $sql = "INSERT INTO `temp_campaign_process_logs` (campaign_title, campaign_lot_id, schedule_time, contact_number, contact_operator, service_type, contact_type, balance, process_status, transaction_id, created_at) ";
        $sql2 = "VALUES ";

        foreach ($contacts as $each){
            $transactionId = randomStringSuffle(16);
            $sql2 .= "('{$campaign['campTitle']}', {$campaign['lotId']}, '{$campaign['scheduleTime']}', $each[0], '$each[1]', '{$campaign['serviceType']}', '$each[2]', $each[3], 'Pending', '{$transactionId}', '{$campaign['createDate']}'),";
        }

        $sql2 = rtrim($sql2, ", ");
        $preSQL = $sql . $sql2;
        return $this->eloquent->executeRawQuery($preSQL);
    }

    /**
     * Get the all Group number list and save it to temporary campaign process table.
     *
     * @param array $campaign
     * @param array $contacts
     * @return int
     */
    public function saveTempCampaignDataFromContactGroup( array $campaign, array $contacts ): int
    {
        $sql3 = "INSERT INTO `temp_campaign_process_logs` (campaign_title, campaign_lot_id, schedule_time, contact_number, contact_operator, service_type, contact_type, balance, process_status, transaction_id, created_at) ";
        $sql4 = "VALUES ";

        foreach ($contacts as $each){
            $transactionId = randomStringSuffle(16);
            $sql4 .= "('{$campaign['campTitle']}', {$campaign['lotId']}, '{$campaign['scheduleTime']}', {$each['contact_number']}, '{$each['contact_operator']}', '{$campaign['serviceType']}', '{$each['contact_type']}', 0, 'Pending', '{$transactionId}', '{$campaign['createDate']}'),";
        }

        $sql4 = rtrim($sql4, ", ");
        $SQL = $sql3 . $sql4;
        return $this->eloquent->executeRawQuery($SQL);
    }

    /**
     * Pick all data per lot id and insert them to campaign process table
     *
     * @param mixed $lotId
     * @return mixed
     */
    public function insertDataToCampaignProcessor(mixed $lotId): mixed
    {
        $insertSqlQuery = "INSERT INTO campaign_processor (campaign_lot_id, schedule_time, contact_number, contact_operator, service_type, contact_type, balance, transaction_id, created_at) 
            SELECT campaign_lot_id, schedule_time, contact_number, contact_operator, service_type, contact_type, balance, transaction_id, created_at  
            FROM temp_campaign_process_logs WHERE campaign_lot_id = $lotId";

        return $this->eloquent->executeRawQuery($insertSqlQuery);
    }

    /**
     * Delete all data from temporary campaign table.
     *
     * @param int $lotId
     * @return mixed
     */
    public function deleteAllDataFromTempCampaignTable(int $lotId): mixed
    {
        $sql = "DELETE FROM temp_campaign_process_logs WHERE campaign_lot_id = $lotId";
        return $this->eloquent->executeRawQuery($sql);
    }

    /**
     * Select the distinct value from temporary camapaing process table and Insert it to campaign list table.
     *
     * @param mixed $lotId
     * @return mixed
     */
    public function insertDataToCampaignList(mixed $lotId): mixed
    {
        $sql1 = "INSERT INTO campaign_lists ( campaign_lot_id, campaign_title, service_type, campaign_status, schedule_time, created_at, total_recharge_amount, total_contact_number ) 
                SELECT DISTINCT campaign_lot_id, campaign_title, service_type, process_status as campaign_status, schedule_time, created_at, 
                                (SELECT SUM(balance) FROM temp_campaign_process_logs) as total_recharge_amount, 
                                (SELECT COUNT(contact_number) FROM temp_campaign_process_logs ) as total_contact_number 
                FROM temp_campaign_process_logs WHERE campaign_lot_id = $lotId GROUP BY id";

        return $this->eloquent->executeRawQuery($sql1);
    }

}