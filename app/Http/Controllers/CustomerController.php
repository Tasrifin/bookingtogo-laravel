<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Nationality;
use App\Models\FamilyList;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Customer::with(['nationality'])->get();
        $data = Customer::with(['families'])->get();
        $data = Customer::paginate(0);
        return view('customer.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $data = Nationality::get();
        return view('customer.add', ['nationalities' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $request->validate([
            "nationality_id" => "required",
            "cst_name" => "required",
            "cst_dob" => "required|date_format:Y-m-d",
            "cst_phoneNum" => "required|numeric",
            "cst_email" => "required|email",
            "fl_name.*" => "required",
            "fl_relation.*" => "required",
            "fl_dob.*" => "required|date_format:Y-m-d",
        ]);

        $data = $request->all();
        try {
            DB::beginTransaction();
            $customer = new Customer();
            $customer->nationality_id = $data["nationality_id"];
            $customer->cst_name = $data["cst_name"];
            $customer->cst_dob = $data["cst_dob"];
            $customer->cst_phoneNum = $data["cst_phoneNum"];
            $customer->cst_email = $data["cst_email"];
            $customer->save();

            if(isset($data["fl_name"])) {
                foreach ($data["fl_name"] as $key => $qty) {
                    $familyList = new FamilyList();
                    $familyList->cst_id = $customer->id;
                    $familyList->fl_name = $data["fl_name"][$key];
                    $familyList->fl_relation = $data["fl_relation"][$key];
                    $familyList->fl_dob = $data["fl_dob"][$key];
                    $familyList->save();
                }
            }
            // db trans commit
            DB::commit();
            // alert success
            return [
                'success' => true
            ];

        } catch (\Exception $e) {
            // db trans rollback
            DB::rollback();
            // alert error
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::where('cst_id', $id)->firstOrFail();
        $familyList = FamilyList::where('cst_id', $id)->get();
        $nationality = Nationality::all();
        
        return view('customer.show', ['customer' => $customer, 'familyLists' => $familyList, 'nationalities' => $nationality]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $customer = Customer::where('cst_id', $id)->firstOrFail();
        $familyList = FamilyList::where('cst_id', $id)->get();
        $nationality = Nationality::all();
        
        return view('customer.edit', ['customer' => $customer, 'familyLists' => $familyList, 'nationalities' => $nationality]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $request->validate([
            "nationality_id" => "required",
            "cst_name" => "required",
            "cst_dob" => "required|date_format:Y-m-d",
            "cst_phoneNum" => "required|numeric",
            "cst_email" => "required|email",
            "fl_name.*" => "required",
            "fl_relation.*" => "required",
            "fl_dob.*" => "required|date_format:Y-m-d",
        ]);

        $data = $request->all();
        try {
            DB::beginTransaction();
            $customer = [
                'nationality_id' => $data["nationality_id"],
                'cst_name' =>  $data["cst_name"],
                'cst_dob' =>  $data["cst_dob"],
                'cst_phoneNum' => $data["cst_phoneNum"],
                'cst_email' =>  $data["cst_email"],
            ];
            Customer::where('cst_id','=',$id)->update($customer);
            
            FamilyList::where('cst_id', $id)->delete();

            if(isset($data["fl_name"])) {
                foreach ($data["fl_name"] as $key => $qty) {
                    $familyList = new FamilyList();
                    $familyList->cst_id = $id;
                    $familyList->fl_name = $data["fl_name"][$key];
                    $familyList->fl_relation = $data["fl_relation"][$key];
                    $familyList->fl_dob = $data["fl_dob"][$key];
                    $familyList->save();
                }
            }
            // db trans commit
            DB::commit();
            // alert success
            return [
                'success' => true
            ];
        } catch (\Exception $e) {
            // db trans rollback
            DB::rollback();
            // alert error
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $customer = Customer::where('cst_id', $id)->get();
            $familyList = FamilyList::where('cst_id', $id)->get();

            FamilyList::where('cst_id', $id)->delete();
            Customer::where('cst_id', $id)->delete();
            // db trans commit
            DB::commit();
            // alert success
            return redirect()->route('customer.index')->with('status', 'Data Deleted Successfully!');
        } catch (\Exception $e) {
            // db trans rollback
            DB::rollback();
            // alert error
            return redirect()->back()->withErrors($e->getMessage());
        }

    }
}
