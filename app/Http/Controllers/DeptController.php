<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\HRISAgusanDepartment;

class DeptController extends Controller
{
    public function index(Request $request)
    {
        $query = "select DISTINCT(DeptDesc) from hrdepartment WHERE DeptDesc like '%".$request->input('text')."%' order by DeptDesc asc";
        $result = DB::connection('sqlsrv')->select($query);

        $str = '';
        foreach($result as $item)
        {
            $str.= 
                '<tr>'.
                '<td>'.$item['DeptDesc'].'</td>'.
                '<td><a href="department-user-maintenance.php?dept='.urlencode($item['DeptDesc']).'" >Select</a></td>'.
                '<td><a href=""></a></td>';
        }
        
        $html = 
        '<table class="table">
			<thead>
				<tr>
					<th>Department</th>
					<th>Action</th>
                </tr>
            </thead>
            <tbody>'.$str.'</tbody>
        </table>';

        return $html;
    }

    
    /**
     * This code is equivalent to hris.php
     * This function will only execute up to "$empdatasql = $pdoempdata->prepare(...)"
     * 
     */

    public function contact(Request $request)
    {
        $name = $request->input('query');
        $query = "SELECT e.EmpID, e.FullName,p.positiondesc,d.DeptDesc 
                    FROM ViewHREmpMaster e 
                    LEFT JOIN hrposition p ON p.PositionID=e.PositionID
                    LEFT JOIN hrdepartment d ON d.deptid=e.deptid 
                    WHERE e.Active = 1 
                    AND e.FullName 
                    LIKE '$name' 
                    ORDER BY e.FullName 
                    ASC";

        $hrisDept = HRISAgusanDepartment::select(DB::raw($query)->get();

        return "data";
    }
}
