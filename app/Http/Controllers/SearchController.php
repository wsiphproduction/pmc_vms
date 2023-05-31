<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\HRISDavaoEmployee;
use App\HRISAgusanEmployee;

use App\HRISDavaoDepartment;
use App\HRISAgusanDepartment;


class SearchController extends Controller
{   

    public function search_hris_employee(Request $req)
    {
        $query = $req->get('query');

        $dataAgusan = HRISAgusanEmployee::where('EmpID','like',"%$query%")->orWhere('FullName','LIKE',"%$query%")->where('Active','=','1')->with(['posDetails','comDetails','deptDetails'])->get();
       
        $dataDavao  = HRISDavaoEmployee::where('EmpID','like',"%$query%")->orWhere('FullName','LIKE',"%$query%")->where('Active','=','1')->with(['posDetails','comDetails','deptDetails'])->get();

         $mergedData = array_merge($dataAgusan->toArray(), $dataDavao->toArray());
        //$mergedData = $dataAgusan->toArray();

        $output = '<ul class="dropdown-menu wd-100p" style="display:block; position:relative">';

        $data = [];  
        foreach($mergedData as $rs) {
                        
            $output .= "<li class='emp_list'><a href='#'>".$rs['EmpID'].': '.$rs['FullName']."<span style='display:none;'>=".$rs['EmpID']."=".$rs['FName']."=".$rs['MName']."=".$rs['LName']."=".$rs['com_details']['CompanyName']."=".$rs['dept_details']['DeptDesc']."=".$rs['pos_details']['PositionDesc']."=".$rs['FullName']."</span></a></li>";
        }

        $output .= '</ul>';

        echo $output;
    }

    public function e_search_hris_employee(Request $req)
    {
        $query = $req->get('query');

        $dataAgusan = HRISAgusanEmployee::where('EmpID','like',"%$query%")->orWhere('FullName','LIKE',"%$query%")->where('Active','=','1')->with(['posDetails','comDetails','deptDetails'])->get();
        // $dataDavao  = HRISDavaoEmployee::where('EmpID','like',"%$query%")->orWhere('FullName','LIKE',"%$query%")->where('Active','=','1')->with(['posDetails','comDetails','deptDetails'])->get();

        // $mergedData = array_merge($dataAgusan->toArray(), $dataDavao->toArray());
        $mergedData = $dataAgusan->toArray();

        $output = '<ul class="dropdown-menu wd-100p" style="display:block; position:relative">';

        $data = [];

        foreach($mergedData as $rs) {
                        
            $output .= "<li class='e_emp_list'><a href='#'>".$rs['EmpID'].': '.$rs['FullName']."<span style='display:none;'>=".$rs['EmpID']."=".$rs['FName']."=".$rs['MName']."=".$rs['LName']."=".$rs['com_details']['CompanyName']."=".$rs['dept_details']['DeptDesc']."=".$rs['pos_details']['PositionDesc']."=".$rs['FullName']."</span></a></li>";
        }

        $output .= '</ul>';

        echo $output;
    }

    public function search_department(Request $req)
    {
        $query = $req->get('query');

        // $dataAgusan = HRISAgusanEmployee::where('EmpID','like',"%$query%")->orWhere('FullName','LIKE',"%$query%")->where('Active','=','1')->with(['posDetails','comDetails','deptDetails'])->get();

        $dataAgusanDept = HRISAgusanDepartment::where('DeptDesc','like',"%$query%")->get()->unique('DeptDesc');

        // $dataDavao  = HRISDavaoEmployee::where('EmpID','like',"%$query%")->orWhere('FullName','LIKE',"%$query%")->where('Active','=','1')->with(['posDetails','comDetails','deptDetails'])->get();

        // $mergedData = array_merge($dataAgusan->toArray(), $dataDavao->toArray());
        $mergedData = array_values(array_unique($dataAgusanDept->toArray(),SORT_REGULAR));  


        $output = '<ul class="dropdown-menu wd-100p" style="display:block; position:relative">';

        $data = [];

        foreach($mergedData as $rs) {
                        
            $output .= "<li class='dept_list'><a href='#'>".$rs['DeptDesc']."<span style='display:none;'>=".$rs['DeptDesc']."</span></a></li>";
        }

        $output .= '</ul>';

        echo $output;
    }

    public function e_search_department(Request $req)
    {
        $query = $req->get('query');

        // $dataAgusan = HRISAgusanEmployee::where('EmpID','like',"%$query%")->orWhere('FullName','LIKE',"%$query%")->where('Active','=','1')->with(['posDetails','comDetails','deptDetails'])->get();

        $dataAgusanDept = HRISAgusanDepartment::where('DeptDesc','like',"%$query%")->get();

        // $dataDavao  = HRISDavaoEmployee::where('EmpID','like',"%$query%")->orWhere('FullName','LIKE',"%$query%")->where('Active','=','1')->with(['posDetails','comDetails','deptDetails'])->get();

        // $mergedData = array_merge($dataAgusan->toArray(), $dataDavao->toArray());
        $mergedData = array_unique($dataAgusanDept->toArray());

        $output = '<ul class="dropdown-menu wd-100p" style="display:block; position:relative">';

        $data = [];

        foreach($mergedData as $rs) {
                        
            $output .= "<li class='e_dept_list'><a href='#'>".$rs['DeptDesc']."<span style='display:none;'>=".$rs['DeptDesc']."</span></a></li>";
        }

        $output .= '</ul>';

        echo $output;
    }



}
