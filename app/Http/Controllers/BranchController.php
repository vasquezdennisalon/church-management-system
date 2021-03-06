<?php

namespace App\Http\Controllers;

use App\Branch;
use App\User;
use Illuminate\Http\Request;
use DB;
use App\H_O_Options;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Yajra\Datatables\Datatables;

class BranchController extends Controller
{
    private $user;

    public function __construct()
    {
      $this->user = \Auth::user();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $user = \Auth::user();
      if(!$user->isAdmin()){
        return redirect()->route('dashboard');
      }
      //$members = Member::all();
      if ($request->draw) {
        $users = User::select('users.*', 'c2.ID', 'c2.currency_symbol', 'c.name')->join('country AS c', 'c.ID', '=', 'users.country')->join('country AS c2', 'c2.ID', '=', 'users.currency')->get();
        return Datatables::of($users)->make(true);
      } else {
        return view('branch.all');
      }
    }

    public function users(){
      return Datatables::of(User::all())->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function edit(Branch $branch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;
        $user = \Auth::user();
        DB::table('users')->where('id', '=', $id)->delete();
         return response()->json(['success' => true,]);
    }

    public function registerForm()
    {
        //
        $user = \Auth::user();

        $sql = "SELECT currency_name, currency_symbol, ID FROM country WHERE currency_name != ''";
        $currencies = \DB::select($sql);

        return ($user->isAdmin()) ? view('branch.register', compact('currencies')) : redirect()->route('dashboard');
    }



    public function register(Request $request)
    {
      $data = [];
      $data['branchname'] = $request->branchname;
      $data['branchcode'] = $request->branchcode;
      $data['address'] = $request->address;
      $data['email'] = $request->email;
      $data['country'] = $request->country;
      $data['state'] = $request->state;
      $data['city'] = $request->city;
      $data['currency'] = $request->currency;
      $data['password'] = $request->password;
      $data['password_confirmation'] = $request->password_confirmation;

      $validate = self::validator($data);
      if($validate->fails()){
        return redirect('/branches/register')->withErrors($validate)->withInput();
      }
      $creation = self::creator($data);
      //
      $s = 'Success';

      return redirect()->route('branch.register', ['s' => $s]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'branchname' => 'bail|required|string|max:255',
            'branchcode' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'country' => 'required|string|max:255',
            'state' =>  'required|string|max:255',
            'city' => 'required|string|max:255',
            'currency' => 'required',
        ]);
    }

    protected function creator(array $data)
    {
      $branch = User::create([
        'branchname' => $data['branchname'],
        'branchcode' => $data['branchcode'],
        'address' => $data['address'],
        'email' => $data['email'],
        'isadmin' => 'false',
        'password' => Hash::make($data['password']),
        'country' => $data['country'],
        'state' => $data['state'],
        'city' => $data['city'],
        'currency' => $data['currency'],
      ]);

      if (!$branch) {
        return $branch;
      }

    }

    public function ho(Request $request){
      $user = \Auth::user();
      $options = \App\head_office_options::all();

      return view('branch.ho', ['options' => $options]);
    }
    public function ho_up(Request $request){
      if(Input::file('img')){
        $img = file_get_contents(Input::file('img')->getRealPath());
      }
        $user = \Auth::user();
        $sname = $request->sname;
        $lname = $request->lname;
        $addr1 = $request->addr1;
        $addr2 = $request->addr2;
        $city = $request->city;
        $state = $request->state;
        $postal = $request->postal;
        $country = $request->country;
        $phone1 = $request->phone1;
        $phone2 = $request->phone2;
        $phone3 = $request->phone3;
        $phone4 = $request->phone4;
        $email  = $request->email;
        //$img = $request->img;
        $id = $request->id;
        $data = ['HOSNAME'=>$sname,
                 'HOLNAME'=>$lname,
                 'HOADDRESS'=>$addr1,
                 'HOADDRESS2'=>$addr2,
                 'HOCITY'=>$city,
                 'HOSTATE'=>$state,
                 'HOPOSTAL_CODE'=>$postal,
                 'HOCOUNTRY'=>$country,
                 'HOPHONE1'=>$phone1,
                 'HOPHONE2'=>$phone2,
                 'HOPHONE3'=>$phone3,
                 'HOPHONE4'=>$phone4,
                 'HOEMAIL'=>$email,
                 ];
                 if(isset($img)){
                  $data['HOLOGO'] = $img;
                 }
        DB::table('head_office_options')->where('HOID', $id)->update($data);

        //foreach($request as $key => $value){

        //}
        //$success =
        //DB::table('head_office_options')->where($options->column, $options->column)->update([$options->column => $options->value]);

        return redirect('/branches/head_office_options');
    }

    public function delete(Request $request){
      $failed = 0;
      $text = "All selected branches were deleted successfully";
      foreach ($request->id as $key => $value) {
        $branch = User::whereId($value)->first();
        if($branch){
          $branch->delete();
        } else {
          $failed++;
          $text = "$failed Operations could not be performed";
        }
      }
      return response()->json(['status' => true, 'text' => $text]);
    }

    public function tools(){
      return view('branch.tools');
    }

    public function options(){
      return view('branch.options');
    }

    public function updateBranch(Request $request){
      $branch = User::whereId($request->id)->first();
      // dd($request);
      if($branch) {
        $errors = [];
        $fields = (array)$request->request;//->parameters;//->ParameterBag->parameters;
        $fields = $fields["\x00*\x00parameters"];
        foreach ($fields as $key => $value) {
          if ($key != 'id' && $key != '_token' && $key != 'action') {
              $branch->$key = $request->$key;
          }
        }
        try {
          $branch->save();
        } catch (\Exception $e) {
          array_push($errors, $e);
          // dd($e);
          return response()->json(['status' => false, 'text' => $e->errorInfo[2]]);
        }
      }
      else {return response()->json(['status' => false, 'text' => "Branch does not exist"]);}
      return response()->json(['status' => true, 'text' => "Branch has been updated!"]);
    }

    public function invoice(Request $request){
      $user = \Auth::user();
      // get due savings
      $dueSavings = \App\CollectionCommission::dueSavings($user);
      // get the commission percentage
      $percentage = (int)(\App\Options::getLatestCommission())->value;
      // dd($dueSavings);
      $details = \App\Options::getLatestCommissionBankDetails();
      // dd($details);
      $options = DB::table('head_office_options')->where('HOID',1)->first();
      $blanceDue = \App\CollectionCommission::calculateUnsettledCommission();
      return view('branch.invoice', compact('details', 'dueSavings', 'percentage', 'blanceDue', 'user', 'options'));
    }
}
