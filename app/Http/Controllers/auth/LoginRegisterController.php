<?php


    namespace App\Http\Controllers\Auth;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Mail\RegistrationSuccess;
    use Illuminate\Support\Facades\Mail;
    use App\Models\User; // Assuming you are using the User model
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Auth;

class LoginRegisterController extends Controller
{
        /*
        * Instantiate a new LoginRegisterController instance.
        */
        public function __construct()
        {
            $this->middleware('guest')->except(['logout']);
        }



        /**
        * Display a registration form.
        *
        * @return \Illuminate\Http\Response
        */
        public function register()
        {
            return view('auth.register');
        }

        /**
        * Store a newly registered user.
        *
        * @param \Illuminate\Http\Request $request
        * @return \Illuminate\Http\Response
        */
        public function store(Request $request)
        {
            // Validate the request data
            $request->validate([
                'name' => 'required|string|max:250',
                'email' => 'required|email|max:250|unique:users',
                'password' => 'required|min:8|confirmed',
            ]);

            // Create a new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'level' => 'user',
                'email_verified_at'=> now()
            ]);

            // Log the user in after registration
            $credentials = $request->only('email', 'password');
            Auth::attempt($credentials);

            // Regenerate session
            $request->session()->regenerate();

            // Mail::to($user->email)->send(new RegistrationSuccess($user));

            // Redirect to dashboard with success message
            return redirect('/buku')->with('login', 'You have successfully registered & logged in!');
        }

        /**
        * Display a login form.
        *
        * @return \Illuminate\Http\Response
        */
        public function login()
        {
            return view('auth.login');
        }

        /**
        * Authenticate the user.
        *
        * @param \Illuminate\Http\Request $request
        * @return \Illuminate\Http\Response
        */
        public function authenticate(Request $request)
        {
            // Validate the request data
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Attempt to log the user in
            if (Auth::attempt($credentials)) {
                // Regenerate session
                $request->session()->regenerate();

                // Redirect to dashboard with success message
                return redirect('/buku')->with('login', 'You have successfully logged in!');
            }

            // If authentication fails, return error
            return back()->withErrors([
                'email' => 'Your provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        /**
        * Display the dashboard to authenticated users.
        *
        * @return \Illuminate\Http\Response
        */
        

        /**
        * Log out the user from the application.
        *
        * @param \Illuminate\Http\Request $request
        * @return \Illuminate\Http\Response
        */
        public function logout(Request $request)
        {
            Auth::logout();

            // Invalidate the session
            $request->session()->invalidate();

            // Regenerate session token
            $request->session()->regenerateToken();

            // Redirect to login with success message
            return redirect('/')->with('logout', 'You have successfully logged out!');;
        }
}