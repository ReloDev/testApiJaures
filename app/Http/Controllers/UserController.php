<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Str;
use Ulid\Ulid;
use Laravel\Passport\HasApiTokens;

/**
 * @OA\Info(
 *      title="test",
 *      version="1.0.0",
 *      description="test",
 *      @OA\Contact(
 *          email="ayenaaurel15@gmail.com",
 *      )
 * )
 */

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try
        {
            $users = User::where('deleted',0)->get();
            return response()->json(['data' => $users]);
        }
        catch (Exception $e)
        {
            return response()->json(['error' => $e->getMessage()]);
        }
    }


    // public function login(Request $request)
    // {
    //     try
    //     {
        
    //         $pattern = "/\\b(SELECT|FROM|DROP|TABLE|INSERT|INTO|<script>|\\/\\*|\\*\\/|\\bunion\\b|\\bor\\b|\\band\\b|\\bupdate\\b|\\balter\\b|\\bcreate\\b|\\bdelete\\b|\\bdrop\\b|\\bexec\\b|\\bexecute\\b|\\balter\\b|\\bbegin\\b|\\bdeclare\\b|\\bcast\\b|\\bmaster\\b|\\btruncate\\b|\\bgrant\\b|\\brevoke\\b|\\bopendatasource\\b|\\bopendatasourcen\\b|\\bxp_cmdshell\\b|\\bsp_password\\b|\\bsp_add_login_mapper\\b|\\bsp_uninstall_addin\\b|\\bsp_start_job\\b|\\bsp_stop_job\\b|\\bsp_add_category\\b|\\bsp_update_category\\b|\\bsp_delete_category\\b|\\bsp_help_category\\b|\\bsp_add_jobserver\\b|\\bsp_update_jobserver\\b|\\bsp_delete_jobserver\\b|\\bsp_help_jobserver\\b|\\bsp_add_job\\b|\\bsp_update_job\\b|\\bsp_delete_job\\b|\\bsp_help_job\\b|\\bsp_add_proxyaccount\\b|\\bsp_update_proxyaccount\\b|\\bsp_delete_proxyaccount\\b|\\bsp_help_proxyaccount\\b|\\bsp_add_schedule\\b|\\bsp_update_schedule\\b|\\bsp_delete_schedule\\b|\\bsp_help_schedule\\b|\\bsp_add_operator\\b|\\bsp_update_operator\\b|\\bsp_delete_operator\\b|\\bsp_help_operator\\b|\\bsp_add_notification\\b|\\bsp_update_notification\\b|\\bsp_delete_notification\\b|\\bsp_help_notification\\b|\\bsp_add_targetservergroup\\b|\\bsp_update_targetservergroup\\b|\\bsp_delete_targetservergroup\\b|\\bsp_help_targetservergroup\\b|\\bsp_add_targetserver\\b|\\bsp_update_targetserver\\b|\\bsp_delete_targetserver\\b|\\bsp_help_targetserver\\b|\\bsp_add_jobstep\\b|\\bsp_update_jobstep\\b|\\bsp_delete_jobstep\\b|\\bsp_help_jobstep\\b|\\bsp_add_jobserver\\b|\\bsp_update_jobserver\\b|\\bsp_delete_jobserver\\b|\\bsp_help_jobserver\\b|\\bsp_add_operator\\b|\\bsp_update_operator\\b|\\bsp_delete_operator\\b|\\bsp_help_operator\\b|\\bsp_add_proxyaccount\\b|\\bsp_update_proxyaccount\\b|\\bsp_delete_proxyaccount\\b|\\bsp_help_proxyaccount\\b|\\bsp_add_schedule\\b|\\bsp_update_schedule\\b|\\bsp_delete_schedule\\b|\\bsp_help_schedule\\b)\\b/i";


    //          $request->validate([
    //              'email' => [
    //                  'required',
    //                  'email',
    //                  'not_regex:' . $pattern
    //              ],
    //              'password' => [
    //                  'required',
    //                  'not_regex:' . $pattern
    //              ],
    //          ]);


    //           $user = DB::table('users')
    //                       ->where('email', $request->email)
    //                       ->first();


    //           if ($user != null) {
    //               $passwordHash = DB::table('users')
    //                               ->where('email', $request->email)
    //                               ->value('password');

    //               if (Hash::check($request->password, $passwordHash)) {
    //                   $token = DB::table('personal_access_tokens')
    //                               ->insertGetId([
    //                                   'tokenable_id' => $user->id,
    //                                   'tokenable_type' => 'App\Models\User',
    //                                   'name' => 'auth_token',
    //                                   'token' => hash('sha256', Str::random(64)),
    //                                   'abilities' => '[]',
    //                                   'created_at' => now(),
    //                                   'updated_at' => now(),
    //                               ]);

    //                   return response()->json([
    //                       'user' => $user,
    //                       'access_token' => $token,
    //                       'token_type' => 'Bearer',
    //                   ]);
    //               } else {
    //                   return response()->json(['error' => 'Mot de passe invalide.'], 401);
    //               }
    //           } else {
    //               return response()->json(['error' => 'Adresse email invalide.'], 401);
    //           }

    //     }
    //     catch (Exception $e)
    //     {
    //         return response()->json(['error' => $e->getMessage()]);
    //     }
    // }

    /**
     * Show the form for creating a new resource.
     */

     /**
 * @OA\Post(
 *     path="/api/users/login",
 *     tags={"Authentication"},
 *     summary="Connexion de l'utilisateur",
 *     description="Permet à l'utilisateur de se connecter en utilisant son e-mail ou son numéro de téléphone et son mot de passe.",
 *     operationId="loginUser",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"username", "password"},
 *             @OA\Property(property="username", type="string", description="Adresse email ou numéro de téléphone de l'utilisateur"),
 *             @OA\Property(property="password", type="string", description="Mot de passe de l'utilisateur")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Connexion réussie, retour de l'utilisateur et du token d'accès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="user", type="object", ref=""),
 *             @OA\Property(property="access_token", type="string", description="Token JWT d'accès"),
 *             @OA\Property(property="token_type", type="string", example="Bearer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Identifiants invalides ou non autorisé",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Adresse email ou numéro de téléphone invalide.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur interne du serveur",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Erreur serveur.")
 *         )
 *     ),
 *     security={{"bearerAuth": {}}}
 * )
 */
    public function login(Request $request)
    {
        try
        {
            $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);
    
            $username = $request->username;
            $password = $request->password;
    
            // Vérifie si l'identifiant est un e-mail ou un numéro de téléphone
            $user = DB::select("
                SELECT * FROM users
                WHERE email = :username OR phone = :username
                LIMIT 1
            ", [
                'username' => $username
            ]);
    
            if (!empty($user)) {
                $hashedPassword = $user[0]->password;
    
                if (password_verify($password, $hashedPassword)) {
                    $authenticatedUser = DB::select("
                        SELECT * FROM users
                        WHERE (email = :username OR phone = :username)
                        AND password = :password
                        LIMIT 1
                    ", [
                        'username' => $username,
                        'password' => $hashedPassword
                    ]);

                    if (!empty($authenticatedUser)) {
                        $token = Auth::attempt(['email' => $username, 'password' => $password]);
                        if (!$token) {
                            $token = Auth::attempt(['phone' => $username, 'password' => $password]);
                        }

                        if (!$token) {
                            return response()->json(['message' => 'Unauthorized'], 401);
                        }

                        $user = Auth::user();
                        DB::update('UPDATE users SET connected = ? WHERE id = ?', [1, $user->id]);

                        return response()->json([
                            'user' => $user,
                            'access_token' => $token,
                            'token_type' => 'Bearer',
                        ]);
                    } else {
                        return response()->json(['error' => 'Mot de passe invalide.'], 401);
                    }
                } else {
                    return response()->json(['error' => 'Mot de passe invalide.'], 401);
                }
            } else {
                return response()->json(['error' => 'Adresse email ou numéro de téléphone invalide.'], 401);
            }
        }
        catch (Exception $e)
        {
            return response()->json(['error' => $e->getMessage()]);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    // public function register(Request $request)
    // {
    //     try
    //     {
    //         $request->validate([
    //             'name' => ['required', 'string'],
    //             'email' => 'required|email|unique:users',
    //             'password' => [
    //                 'required',
    //                 'string',
    //                 'min:8',
    //                 'confirmed',
    //                 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
    //             ],
    //             'password_confirmation' => 'required|string',
    //         ]);
    //         $user = new User();
    //         $user->name = $request->name;
    //         $user->email = $request->email;
    //         $user->password =bcrypt($request->password);
    //         $user->save();
    //         return response()->json('User created successfully');
    //     }
    //     catch (Exception $e)
    //     {
    //         return response()->json(['error' => $e->getMessage()]);
    //     }
    // }

    public function register(Request $request)
{
    try
    {

        // Validation des données d'entrée
       $request->validate([
           'phone' => 'required|integer',
           'email' => 'required|email|unique:users',
           'password' => [
               'required',
               'string',
               'min:8',
               'confirmed',
               'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]+$/',
           ],
           'password_confirmation' => 'required|string',
       ]);


    //    dd('salut');

       $ulid = Uuid::uuid1();
       $ulidUser = $ulid->toString();


      $db = DB::connection()->getPdo();
      $phone =  htmlspecialchars($request->input('phone'));
      $email =  htmlspecialchars($request->input('email'));
      $password = bcrypt($request->input('password'));
      $last_ip_login = $request->ip();
      $uid = $ulidUser;

    //   dd($ip_last_login);

      $query = "INSERT INTO users (phone, email, password,uid,last_ip_login) VALUES (?, ?, ?, ?, ?)";

      $statement = $db->prepare($query);

      $statement->bindParam(1, $phone);
      $statement->bindParam(2, $email);
      $statement->bindParam(3, $password);
      $statement->bindParam(4,  $uid);
      $statement->bindParam(5,  $last_ip_login);


      $statement->execute();

      $user = User::where('email', $email)->first();
      $ulid = Uuid::uuid1();
      $ulidPeople = $ulid->toString();
      $first_name =  'XXXXX';
      $last_name =  'XXXXX';
      $user_id = $user->id;
      $connected = 1;
      $sex = 1;
      $dateofbirth =  date('Y-m-d');
      $profile_img_code=  'XXX';
      $first_login =  1;
      $phonenumber =   12345678;
      $deleted = 0;
      $type =  'XXXXX';
      $uid = $ulidPeople;

     

        return response()->json('User created successfully');
    }
    catch (Exception $e)
    {
        return response()->json(['error' => $e->getMessage()]);
    }
}


public function logout()
{
    dd(Auth::user());
        $user = Auth::user();
        DB::update('UPDATE users SET connected = ? WHERE id = ?', [0, $user->id]);

        Auth::logout();

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
}


   /**
 * @OA\Get(
 *     path="/api/user",
 *     summary="Obtenir les informations de l'utilisateur authentifié",
 *     description="Renvoie les informations de l'utilisateur authentifié.",
 *     tags={"Authentication"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="Informations de l'utilisateur récupérées avec succès",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="data",
 *                 description="Détails de l'utilisateur authentifié"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Non autorisé",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="error",
 *                 type="string",
 *                 description="Message d'erreur"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erreur serveur",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="error",
 *                 type="string",
 *                 description="Détails de l'erreur serveur"
 *             )
 *         )
 *     )
 * )
 */
    public function userAuth(Request $request){
        try{

            $user = User::whereId(Auth::user()->id)->get();

            // return $user[0]->file[0]->location;

                if($user[0]->file[0]){
                    $user[0]->location = $user[0]->file[0]->location;
                }
         

            $data = ["user"=>$user] ;

             return response()->json($data);

        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    // public function a(){
        
    //     $request = new Request();
    //     return response()->json([
    //         'data' => $this->userAuth( $request )
    //     ]);
    // }

    public function page(){

        return view('app');
    }

}
