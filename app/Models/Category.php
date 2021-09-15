<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Category extends Model
{
    use HasFactory;


    private static function getQueryFlat($input, $selectColumn, $query, $total)
    {

        $selectColArray = explode(",", $selectColumn);
        //echo $selectColArray[0];

        $whereStr = '';
        $i = 1;
        foreach ($input['columns'] as $key => $value) {
            if (isset($value['search']['regex'])) {
                //echo "Sdf";
                if ($value['search']['value'] != '') {
                    $val = $value['search']['value'];
                    $val = str_replace("^", '', $val);
                    $val = str_replace("$", '', $val);
                    $val = str_replace('\\', '', $val);

                    //  $val=preg_replace('/[^A-Za-z0-9\-]/', ' ',$val);
                    if ($i == 1) {
                        $whereStr .= $selectColArray[$key] . " like '%" . $val . "%' ";
                    } else {
                        $whereStr .= ' and ' . $selectColArray[$key] . " like '%" . $val . "%' ";
                    }
                    $i++;
                }
            }
        }
        $whereFullLike = '';
        if ($whereStr != '') {
            $whereFullLike .= "WHERE $whereStr";
        }


        //  $this->pr($input);
        $limit = $input['length'];
        $start = $input['start'];
        if ($start > $total) {
            $start = 0;
        }
        $order = 'desc';

        $orderByStr = 'desc';
        if (isset($input['order'][0]['column'])) {

            $col = $selectColArray[$input['order'][0]['column']];
            $order = $input['order'][0]['dir'];
            $orderByStr = "ORDER BY $col $order";
        }

        return  $queryFinal = $query . " $whereFullLike $orderByStr  limit $limit offset $start";
    }


    public static function getDataTable($input, $collection)
    {
       
        $sl     = 1;
        $data   = array();
        if ($collection) {
            foreach ($collection['data'] as $key => $item) {
                $row    = array();
                $row[]  = $sl;
                $row[]  = $item->name;
                $row[] = "<span style='float:right'></span>";

                $data[] = $row;
                $sl++;
            }
        }

        $output = array(
            "draw"              => $input['draw'],
            "recordsTotal"      => $collection['total'],
            "recordsFiltered"   => $collection['filtered'],
            "data"              => $data
        );
        return $output;
    }
    public static function getData($input)
    {

        $totalArray = DB::selectOne("SELECT count(*)  total FROM categories a");
        $total = 0;
        if (!empty($totalArray)) {
            $total = $totalArray->total;
        }

        if ($input['search']['value'] != '') {
            $selectColumn = "id, name";
            $query = "SELECT * from (SELECT $selectColumn FROM categories) k";
            $sql = self::getSearchQuery($input, $selectColumn, $query, $total);
            $data = DB::select($sql[0]);
    
            $filtered = $sql[1];
            return array('data' => $data, 'total' => $total, 'filtered' => $filtered);
        } else {
            $selectColumn = "id, name";
            $query = "SELECT $selectColumn from categories";
            $sql = self::getQueryFlat($input, $selectColumn, $query, $total);
            $data = DB::select($sql);
        }
        return array('data' => $data, 'total' => $total, 'filtered' => $total);
    }
}
