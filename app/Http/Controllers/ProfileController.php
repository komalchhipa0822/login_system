<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User,Department,Designation};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['department']=Department::get();
        $data['user']=User::with('department','designation')->where('id',Auth::user()->id)->first();


         return view('profile..index',compact('data'));
    }

    public function get_degination(Request $request)
    {
        $data['deginations']=Designation::where('department_id','=',$request->department_id)->get(["name", "id"]);

        return response()->json($data);
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
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            'prefix' => ['required', 'string'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
        ]);


        if(isset($request->image) && !empty($request->image)){
                $image = time() . 'user_' . strtolower(substr($request->first_name, 0, 3)) . '.' . $request->image->extension();
                $request->image->move(public_path('images/users/profile/'), $image);
            } else {
                if($request->remove_img == '1')
                {
                    $image='';
                }
                else
                {
                     $image = Auth::user()->image;
                 }
            }

            $user=User::find(Auth::user()->id);
        $update=[
            'prefix' => $request->prefix,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => Auth::user()->email,
            'dob' => $request->dob,
            'about' => $request->about,
            'department_id' => $request->department_id,
            'designation_id' => $request->designation_id,
            'address' => $request->address,
            'phone' => $request->phone,
            'image'=>$image
        ];
        $result= $user->update($update);

       if($result)
        {
            return redirect()->route('profile.index')
                        ->with('success','profile updated successfully');

        }
        else
        {
            return redirect()->route('profile.index')
                        ->with('error','Something wrong');
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
        //
    }
}
