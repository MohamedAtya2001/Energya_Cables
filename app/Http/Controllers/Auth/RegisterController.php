<?php

namespace App\Http\Controllers\Auth;

use App\Admin;
use App\Armouring;
use App\Assembly;
use App\Bedding;
use App\CCVInsulation;
use App\Drowing;
use App\Http\Controllers\Controller;
use App\Insulation;
use App\Lead;
use App\Mail\SendMail;
use App\Providers\RouteServiceProvider;
use App\Rules\Password;
use App\Screen;
use App\Sheathing;
use App\Stranding;
use App\Taps;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function index()
    {
        return view('auth.register');
    }

    public function AuthinticationEmail(Request $request)
    {
        $validator = $request->validate([
            'name' => ['required', 'unique:admins'],
            'email' => ['required', 'email', 'unique:admins'],
            'password' => ['required', new Password],
            'class' => ['required']
        ]);

        $details = [
            'name' => $request->name,
            'email' => $request->email,
            'code' => rand(100000, 999999)
        ];

        Mail::to($request->email)->send(new SendMail($details));

        return $details['code'];
    }

    public function registerEmployee(Request $request)
    {
        $validator = $request->validate([
            'name' => ['required', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', new Password],
            'class' => ['required']
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        for ($i = 1; $i <= 10; $i++) {

            if ($i <= 2) {
                // To Add rows Of New Employee In Insulation Table
                $insulationRows = new Insulation();
                $insulationRows->form_item = $i;
                $insulationRows->employee_name = $user->name;
                $insulationRows->save();

                // To Add rows Of New Employee In Bedding Table
                $beddingRows = new Bedding();
                $beddingRows->form_item = $i;
                $beddingRows->employee_name = $user->name;
                $beddingRows->save();

                // To Add rows Of New Employee In Armouring Table
                $armouringRows = new Armouring();
                $armouringRows->form_item = $i;
                $armouringRows->employee_name = $user->name;
                $armouringRows->save();

                // To Add rows Of New Employee In Taps Table
                $tapsRows = new Taps();
                $tapsRows->form_item = $i;
                $tapsRows->employee_name = $user->name;
                $tapsRows->save();
            }

            if ($i <= 3) {
                // To Add rows Of New Employee In Assembly Table
                $assemblyRows = new Assembly();
                $assemblyRows->form_item = $i;
                $assemblyRows->employee_name = $user->name;
                $assemblyRows->save();

                // To Add rows Of New Employee In Screen Table
                $screenRows = new Screen();
                $screenRows->form_item = $i;
                $screenRows->employee_name = $user->name;
                $screenRows->save();

                // To Add rows Of New Employee In Lead Table
                $leadRows = new Lead();
                $leadRows->form_item = $i;
                $leadRows->employee_name = $user->name;
                $leadRows->save();

                // To Add rows Of New Employee In CCVInsulation Table
                $CCVInsulationRows = new CCVInsulation();
                $CCVInsulationRows->form_item = $i;
                $CCVInsulationRows->employee_name = $user->name;
                $CCVInsulationRows->save();
            }

            if ($i <= 4) {
                // To Add rows Of New Employee In Drowing Table
                $drowingRows = new Drowing();
                $drowingRows->form_item = $i;
                $drowingRows->employee_name = $user->name;
                $drowingRows->save();

                // To Add rows Of New Employee In Sheathing Table
                $sheathingRows = new Sheathing();
                $sheathingRows->form_item = $i;
                $sheathingRows->employee_name = $user->name;
                $sheathingRows->save();
            }

            // To Add rows Of New Employee In Stranding Table
            $strandingRows = new Stranding();
            $strandingRows->form_item = $i;
            $strandingRows->employee_name = $user->name;
            $strandingRows->save();
        }
    }

    public function registerAdmin(Request $request)
    {

        // return $this->code;

        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->save();
    }
}
