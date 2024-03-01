<?php

namespace App\Logic;

use App\Models\PmcTestModel;
use App\Class\General;

class PmcTestLogic
{
    public static function GenerarTokenSeguridad()
    {
        $username = 'Sandbox';
        $password = 'FjWJNxn8TbKz2Mz4aRFQvnf8ApPLug72';

        $curl = curl_init();

        $options = array(
            CURLOPT_URL => "https://pdss.eastus.cloudapp.azure.com/webservice/Users/Login",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => [
                "X-ENCRYPTED: 0",
                "x-api-key:z2WYcMmWT8PTNT36mervcMBhc65bQ2Jy"
            ],
            CURLOPT_USERPWD => "$username:$password",
            CURLOPT_POSTFIELDS => "userName=Sandbox&password=SandboxAPI2023!Aug"

        );

        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        $result = json_decode($response, true);

        ///lee campos y datos del json
        foreach ($result['result'] as $k => $v) {
            if ($k == 'token') {
                echo "key: $k  \t/\t value: $v" . PHP_EOL;
            }
        }

        if ($err) {
            $response = "CURL Error #:" . $err;
        }
    }

    public static function CasesRecordsLists()
    {
        $username = 'Sandbox';
        $password = 'FjWJNxn8TbKz2Mz4aRFQvnf8ApPLug72';

        $xtoken = "e7b67353f15d8b3e86290b0c717d63bd335fcf7f";

        $curl = curl_init();

        $options = array(
            CURLOPT_URL => "https://pdss.eastus.cloudapp.azure.com/webservice/Cases/RecordsList",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-api-key:z2WYcMmWT8PTNT36mervcMBhc65bQ2Jy",
                "x-token:" . $xtoken
            ],
            CURLOPT_USERPWD => "$username:$password",
            CURLOPT_POSTFIELDS => "userName=Sandbox&password=SandboxAPI2023!Aug"

        );

        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $result = json_decode($response, true);

        $newrecords = array();
        foreach ($result['result']['records'] as $k => $v) {
            $newrecords[] = array(
                'recordid'                        => $k
            );
        }

        if ($err) {
            $response = "CURL Error #:" . $err;
        }

        $data['recordscab'] = General::convertir_array_a_xml($newrecords);

        $response = PmcTestModel::ToRegisterUpdateCab($data);

        $message = 'No se recibio respuesta de la Base Datos';
        $success = TRUE;

        if (!General::isEmpty($response)) {
            $message = $response->message;
            unset($response->message);
            $success = ($response->success == 0 ? TRUE : FALSE);
            unset($response->success);
            if (!$success) {
                $response = null;
            }
        }

        return [$response, $message, $success];
    }

    public static function GetCaseWithRecordId()
    {
        $username = 'Sandbox';
        $password = 'FjWJNxn8TbKz2Mz4aRFQvnf8ApPLug72';
        $xtoken = "e7b67353f15d8b3e86290b0c717d63bd335fcf7f";

        $message = 'No se recibio respuesta de la Base Datos';
        $success = TRUE;

        $response_records_cab = PmcTestModel::ToListRecordsCab();
        $recordid = 0;

        foreach ($response_records_cab as $records_cab) {
            $recordid = $records_cab->recordid;

            $curl = curl_init();
            $options = array(
                CURLOPT_URL => "https://pdss.eastus.cloudapp.azure.com/webservice/Cases/Record/" . $recordid,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "x-api-key:z2WYcMmWT8PTNT36mervcMBhc65bQ2Jy",
                    "x-token:" . $xtoken
                ],
                CURLOPT_USERPWD => "$username:$password",
                CURLOPT_POSTFIELDS => "userName=Sandbox&password=SandboxAPI2023!Aug"

            );

            curl_setopt_array($curl, $options);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                $response = "CURL Error #:" . $err;
            }

            $result = json_decode($response, true);

            $newrecords = array();
            $newrecords[] = array(                
                'case_id' =>  $result['result']['data']['case_id'],
                'provider' =>  $result['result']['data']['provider'],
                'insured' =>  $result['result']['data']['insured'],
                'type_of_claim' =>  $result['result']['data']['type_of_claim'],
                'case_number' =>  $result['result']['data']['case_number'],
                'first_notice_of_loss' =>  $result['result']['data']['first_notice_of_loss'],
                'types_of_services' =>  $result['result']['data']['types_of_services'],
                'total_bill_amount' =>  $result['result']['data']['total_bill_amount'],
                'total_collections' =>  $result['result']['data']['total_collections'],
                'total_balance' =>  $result['result']['data']['total_balance'],
                'voluntary_payment_date' =>  $result['result']['data']['voluntary_payment_date'],
                'policy_number' =>  $result['result']['data']['policy_number'],
                'insurance_company' =>  $result['result']['data']['insurance_company'],
                'day_demand_sent_10' =>  $result['result']['data']['10_day_demand_sent'],
                'case_filed' =>  $result['result']['data']['case_filed'],
                'corporate_representative' =>  $result['result']['data']['corporate_representative'],
                'engineer' =>  $result['result']['data']['engineer'],
                'insurance_expert' =>  $result['result']['data']['insurance_expert'],
                'pricing_expert' =>  $result['result']['data']['pricing_expert'],
                'indoor_environmental_professio' =>  $result['result']['data']['indoor_environmental_professio'],
                'inspector' =>  $result['result']['data']['inspector'],
                'ps_corporate_rep' =>  $result['result']['data']['ps_corporate_rep']
            );         

            $data = array();
            $data['recordid'] = $recordid;
            $data['recordsdet'] = General::convertir_array_a_xml($newrecords);

            $response = PmcTestModel::ToRegisterUpdateDet($data);

            if (!General::isEmpty($response)) {
                $message = $response->message;
                unset($response->message);
                $success = ($response->success == 0 ? TRUE : FALSE);
                unset($response->success);
                if (!$success) {
                    $response = null;
                }
            }
        }
        return [$response, $message, $success];
    }

    public static function ProbandoTabla()
    {
        $resultado = PmcTestModel::ProbandoTabla();
        return $resultado;
    }
}
