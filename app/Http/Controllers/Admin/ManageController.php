<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Facility;
use App\Barangay;
use App\Patient;
use App\User;
use App\Countries;
use App\Region;
use App\MunicipalCity;
use App\Province;
use App\PendingMeeting;
class ManageController extends Controller
{
	public function __construct()
    {
        if(!$login = Session::get('auth')){
            $this->middleware('auth');
        }
    }
    
    public function AdminFacility() {
    	$user = Session::get('auth');
    	$facility = Facility::find($user->facility_id);
    	$province = Province::all();
    	return view('admin.facility',[
            'facility' => $facility,
            'province' => $province
        ]);
    }

    public function updateFacility(Request $req) {
    	Facility::find($req->id)->update($req->all());
    	Session::put("action_made","Successfully updated facility");
    }

    public function patientList(Request $request)
    {
        $user = Session::get('auth');

        $municity =  MunicipalCity::where('prov_psgc', $user->facility->province->prov_psgc)->get();
        $province = Province::all();
        if($request->view_all == 'view_all')
            $keyword = '';
        else{
            if(Session::get("keyword")){
                if(!empty($request->keyword) && Session::get("keyword") != $request->keyword)
                    $keyword = $request->keyword;
                else
                    $keyword = Session::get("keyword");
            } else {
                $keyword = $request->keyword;
            }
        }
        Session::put('keyword',$keyword);
        $data = Patient::select(
            "patients.*",
            "bar.brg_name as barangay",
            "user.email as email",
            "user.username as username",
        ) ->leftJoin("barangays as bar","bar.brg_psgc","=","patients.brgy")
        ->leftJoin("users as user","user.id","=","patients.account_id")
        ->where('patients.doctor_id', $user->id)
        ->where(function($q) use ($keyword){
            $q->where('patients.fname',"like","%$keyword%")
                ->orwhere('patients.lname',"like","%$keyword%")
                ->orwhere('patients.mname',"like","%$keyword%");
               
            })
            ->orderby('patients.lname','asc')
            ->paginate(30);

        $patients = Patient::select(
            "patients.*",
            "bar.brg_name as barangay",
            "user.email as email",
            "user.username as username",
        ) ->leftJoin("barangays as bar","bar.brg_psgc","=","patients.brgy")
        ->leftJoin("users as user","user.id","=","patients.account_id")
        ->where('patients.doctor_id', $user->id)->get();

        $doctors = User::where('level', 'doctor')
                       ->where('facility_id', $user->facility_id)
                       ->get();
        $nationality = Countries::orderBy('nationality', 'asc')->get();
        $region = Region::all();
        $nationality_def = Countries::where('num_code', '608')->first();
        return view('admin.patient',[
            'data' => $data,
            'municity' => $municity,
            'patients' => $patients,
            'users' => $doctors,
            'nationality' => $nationality,
            'nationality_def' => $nationality_def,
            'region' => $region,
            'province' => $province,
            'user' => $user
        ]);
    }

    public function schedTeleStore(Request $req) {
        $date = date('Y-m-d', strtotime($req->date_from));
        $req->request->add([
            'status' => 'Pending',
            'datefrom' => $date
        ]);
        if($req->meeting_id) {
            PendingMeeting::find($req->meeting_id)->update($req->except('meeting_id', 'facility_id', 'date_from'));
        } else {
            PendingMeeting::create($req->except('meeting_id', 'facility_id', 'date_from'));
        }
        Session::put("action_made","Please wait for the confirmation of doctor.");
    }

    public function meetingInfo(Request $req) {
        $meeting = PendingMeeting::find($req->meet_id);
        return json_encode($meeting);
    }
    public function clinical($id) {
        $patient = Patient::find($id);
        return view('admin.clinical',[
            'patient' => $patient
        ]);
    }
    public function covid($id) {
    }
    public function diagnosis($id) {
    }
    public function plan($id) {
    }
}
