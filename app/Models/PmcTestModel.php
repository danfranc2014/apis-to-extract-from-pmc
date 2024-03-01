<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class PmcTestModel
{

    public static function ToRegisterUpdateCab(array $data): Object
    {
        $parametros = array(
            $data['recordscab']
        );
        var_dump($parametros);
        exit();
        $res = DB::select("CALL sp_records_cab(?)", $parametros);
        return $res[0] ?? null;
    }
    public static function ToRegisterUpdateDet(array $data): Object
    {
        $parametros = array(
            $data['recordsdet']
        );
        $res = DB::select("CALL sp_records_dets(?)", $parametros);
        var_dump($res);
        exit();
        return $res[0] ?? null;
    }
    public static function ToListRecordsCab(): array
    {
        $res = DB::select("CALL sp_list_recordscab()");
        return $res;
    }
    public static function ProbandoTabla(): array
    {

        $sql = "CREATE TABLE records (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            recordscode INT NOT NULL       
            )";


        $qi = "INSERT INTO records (recordscode";
        $qi .= ") VALUES (";

        $j_obj = array();

        foreach ($j_obj as $j_arr_key => $value) {
            $qi .= "'" . $value . "',";
        }
        $qi .= ")";


        $users = DB::select($sql);
        $users = DB::select($qi);
        return $users;
    }
}
