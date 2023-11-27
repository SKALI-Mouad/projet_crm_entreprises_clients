<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\Entreprise;
use App\Models\User;
use App\Models\Log;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Validation\Rule;
//use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail as FacadesMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ConfirmMail;
use Illuminate\Support\Facades\Auth;


class EmployeController extends Controller
{
    public function index(Request $request) {
        $searchEmploye = $request->search;
        $filtreEmploye = $request->filtre;
        $employes = Employe::with("entreprise")
        ->where('is_verified', '=', '1')
        ->when($searchEmploye, function($query) use($searchEmploye){
            $query->where("nom_employe", "like", "%".$searchEmploye."%");
            $query->orWhere("prenom_employe", "like", "%".$searchEmploye."%");
        })
        ->when($filtreEmploye, function($query) use($filtreEmploye){
            $query->where("entreprise_id", $filtreEmploye);
        })
        ->orderBy("nom_employe", "ASC")
        ->paginate(5);
        $entreprises = Entreprise::all();
        return inertia("Employe/IndexEmploye", [
            "employes" => $employes,
            "entreprises" => $entreprises,
            "filtres" => $request->all("search", "filtre")
        ]);
    }
    public function indexInvitation(Request $request) {
        $searchEmploye = $request->search;
        $filtreEmploye = $request->filtre;
        $employes = Employe::with("entreprise")
        ->where('invitation_deleted', '=', '0')
        ->where('is_verified', '=', '0')
        ->when($searchEmploye, function($query) use($searchEmploye){
            $query->where("nom_employe", "like", "%".$searchEmploye."%");
            $query->orWhere("prenom_employe", "like", "%".$searchEmploye."%");
        })
        ->when($filtreEmploye, function($query) use($filtreEmploye){
            $query->where("entreprise_id", $filtreEmploye);
        })
        
        ->orderBy("nom_employe", "ASC")
        ->paginate(5);
        $entreprises = Entreprise::all();
        return inertia("Employe/IndexInvitation", [
            "employes" => $employes,
            "entreprises" => $entreprises,
            "filtres" => $request->all("search", "filtre")
        ]);
    }
    public function create() {
        $entreprises = Entreprise::all();
        return inertia("Employe/CreationEmploye", [
            "entreprises" => $entreprises
        ]);
    }
    public function store(Request $request) {
        $validatedData = $request->validate([
            "nom_employe" => "required",
            "prenom_employe" => "required",
            "sexe_employe" => "",
            "numero_telephone_employe" => "",
            "photo_employe" => "",
            "email_employe" => "required|unique:App\\Models\Employe",
            "id" => "required|exists:Entreprises",
        ]);

        $name = $request->nom_employe." ".$request->prenom_employe;
        //$name = $request->nom_employe;
        $userName = $name;
        $userEmail = $request->email_employe;
        $userAdmin = "0";
        $userPassword = "password";

        // Employe::create([...$validatedData, "entreprise_id" => $request->id]);
       
        $user = User::create([
            "name" => $name,
            "email" => $userEmail,
            "isAdmin" => $userAdmin,
            "password" => $userPassword,
            "remember_token" => Str::random(40),
        ]);
        

        $userStored = User::where('email', '=', $userEmail)->first();
        //dd($userStored->id);
        $userStoredId = $userStored->id;

        Mail::to($user->email)->send(new ConfirmMail($user));

        $employe = Employe::create([...$validatedData,"user_id" => $userStoredId, "entreprise_id" => $request->id]);

        $entreprise = Entreprise::where('id', '=', $request->id)->first();
        $nomEntreprise = $entreprise->nom_entreprise;
        $admin = Auth::user();
        $adminName = $admin->name;
        $adminEmail = $admin->email;
        $description = "Admin $adminName a invité l'employé $name à joindre la société $nomEntreprise";

        $log = Log::create([
            "nom_admin" => $adminName,
            "email_admin" => $adminEmail,
            "nom_employe" => $userName,
            "email_employe" => $userEmail,
            "description" => $description,
            "time" => now(),
        ]);


        try {
        if ($request->hasFile("photo_employe")) {
            $photo = $request->photo_employe;
            // $extention = explode('.', $photo->getClientOriginalName());
            // $extention2 = array_pop($extention);
            $name = $request->nom_employe." ".$request->prenom_employe;
            //$fileName = $photo->getClientOriginalName();
            $fileName = str_replace(" ", "_", $name);
            $filePath = $photo->storeAs("photos", $fileName, "public");
            $employe->photo_employe = $filePath;
            $employe->save();
        }
        else {

            return redirect()->back();
        }
       } catch (Exception $e) {
       }
        return redirect()->back();
    }
    public function verify($token) {
        $user = User::where('remember_token', '=', $token)->first();
        if (!empty($user)) {
            $user->email_verified_at = now();
            $user->remember_token = Str::random(40);
            $userName = $user->name;
            $userEmail = $user->email;
            $user->save();
            // $employe = Employe::where('email_employe', '=', $user->email)->first();
            // $employe->update(["is_verified" => "1"]);
            $employe = Employe::where('email_employe', '=', $userEmail)->first();
            $entrepriseId = $employe->entreprise_id;
            $entreprise = Entreprise::where('id', '=', $entrepriseId)->first();
            $nomEntreprise = $entreprise->nom_entreprise;
            $description = "$userName a validé l'invitation à joindre la société $nomEntreprise";

            $log = Log::create([
                "nom_admin" => "",
                "email_admin" => "",
                "nom_employe" => $userName,
                "email_employe" => $userEmail,
                "description" => $description,
                "time" => now(),
            ]);

            return redirect('login');
        } else {
            abort(404);
        }
    }

    public function modification(Employe $employe) {

        $entreprises = Entreprise::all();
        return inertia("Employe/ModificationEmploye", [
            "entreprises" => $entreprises,
            "employe" => $employe
        ]);
    }
    public function update(Request $request, Employe $employe) {

        //dd($employe);
        $validatedData = $request->validate([
            "nom_employe" => "required",
            "prenom_employe" => "required",
            "sexe_employe" => "",
            "numero_telephone_employe" => "",
            "photo_employe" => "",
            "email_employe" => ["required",
            Rule::unique( (new Employe)->getTable(), "email_employe" )->ignore($employe->id),
            ],
            "id" => "required|exists:Entreprises",
        ]);

        $employe->update([...$validatedData, "entreprise_id" => $request->id]);

        $nameUser = $request->nom_employe." ".$request->prenom_employe;
        $user = User::find($employe->user_id);
        $user->update([
            "name" => $nameUser,
            "email" => $request->email_employe,
        ]);

        try {
            if ($request->hasFile("photo_employe")) {
                if (Storage::exists($employe->photo_employe)) {
                    Storage::delete($employe->photo_employe);
                }
                $photo = $request->photo_employe;
                // $extention = explode('.', $photo->getClientOriginalName());
                // $extention2 = array_pop($extention);
                $name = $request->nom_employe." ".$request->prenom_employe;
                //$fileName = $photo->getClientOriginalName();
                $fileName = str_replace(" ", "_", $name);
                $filePath = $photo->storeAs("photos", $fileName, "public");
                $employe->photo_employe = $filePath;
                $employe->save();
            }
            else {
    
                return redirect()->back();
            }
           } catch (Exception $e) {

           }

    }
    public function activityLog() {
        $logs = Log::orderBy("time", "DESC")->paginate(5);
        return inertia("Log/ActivityLog", [
            "logs" => $logs
        ]);
    }
    public function delete(Employe $employe) {

        if ($employe->photo_employe) {
            //Log::debug('Reached this point');
            $photo = $employe->photo_employe;
            Storage::disk('public')->delete($photo);
        }
        //$userId = $employe->user_id;
        $emailEmploye = $employe->email_employe;
        $user = User::where('email', '=', $emailEmploye);
        $user->delete();
        $employe->delete();
        return redirect()->back();
    }
    public function deleteInvitation(Employe $employe) {

        if ($employe->photo_employe) {
            //Log::debug('Reached this point');
            $photo = $employe->photo_employe;
            Storage::disk('public')->delete($photo);
        }
        $employe->update(["invitation_deleted" => "1", "user_id" => "0"]);
        $emailEmploye = $employe->email_employe;
        $user = User::where('email', '=', $emailEmploye)->first();
        $userName = $user->name;
        $userEmail = $user->email;
        $entrepriseId = $employe->entreprise_id;
        $entreprise = Entreprise::where('id', '=', $entrepriseId)->first();
        $nomEntreprise = $entreprise->nom_entreprise;
        $admin = Auth::user();
        $adminName = $admin->name;
        $adminEmail = $admin->email;
        $description = "Admin $adminName a annulé l'invitation de l'employé $userName à joindre la société $nomEntreprise";

        $log = Log::create([
            "nom_admin" => $adminName,
            "email_admin" => $adminEmail,
            "nom_employe" => $userName,
            "email_employe" => $userEmail,
            "description" => $description,
            "time" => now(),
        ]);
        $user->delete();
        return redirect()->back();

        
    }
}
