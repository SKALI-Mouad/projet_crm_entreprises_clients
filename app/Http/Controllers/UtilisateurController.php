<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\Entreprise;
use App\Models\User;
use App\Models\Log;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UtilisateurController extends Controller
{
    public function index(Request $request) {
        //$id = Auth::id();
        $user = Auth::user();
        $userEmail = $user->email;
        $user = DB::table('employes')->where('email_employe', $userEmail)->first();
        //$utilisateur = Employe::find($id);
        $entrepriseId = $user->entreprise_id;
        $searchEmploye = $request->search;
        $filtreEmploye = $request->filtre;
        $employes = Employe::with("entreprise")
        ->when($searchEmploye, function($query) use($searchEmploye){
            $query->where("nom_employe", "like", "%".$searchEmploye."%");
            $query->orWhere("prenom_employe", "like", "%".$searchEmploye."%");
        })
        ->when($filtreEmploye, function($query) use($filtreEmploye){
            $query->where("entreprise_id", $filtreEmploye);
        })
        ->where('entreprise_id', '=', $entrepriseId)
        ->where('is_verified', '=', '1')
        ->orderBy("nom_employe", "ASC")
        ->paginate(5);
        $entreprises = Entreprise::find($entrepriseId);
        return inertia("Utilisateur/IndexUtilisateur"
        ,[
            "employes" => $employes,
            "entreprises" => $entreprises,
            "filtres" => $request->all("search", "filtre")
        ]
    )->with('userInfo',$user);;
    }

    public function modification(Employe $employe) {

        //$employe = Employe::where('email_employe', '=', '$userEmail')->first();
        $entreprises = Entreprise::all();
        return inertia("Utilisateur/ModificationUtilisateur", [
            "entreprises" => $entreprises,
            "employe" => $employe
        ]);
    }
    public function confirmation() {

        $user = Auth::user();
        $userEmail = $user->email;
        $employe = Employe::where('email_employe', '=', $userEmail)->first();

        $entreprises = Entreprise::all();
        return inertia("Utilisateur/ConfirmationUtilisateur", [
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

        $employe->update([...$validatedData, "is_verified" => 1, "entreprise_id" => $request->id]);

        $nameUser = $request->nom_employe." ".$request->prenom_employe;
        $user = User::find($employe->user_id);
        if ($request->mdp != "") {
            $user->update([
                "name" => $nameUser,
                "email" => $request->email_employe,
                "password" => Hash::make($request->mdp),   
            ]);
        } else {
            $user->update([
                "name" => $nameUser,
                "email" => $request->email_employe,
            ]);
        }

        $userName = $user->name;
        $userEmail = $user->email;
        $description = "$userName à confirmé son profile";

        $log = Log::create([
            "nom_admin" => "",
            "email_admin" => "",
            "nom_employe" => $userName,
            "email_employe" => $userEmail,
            "description" => $description,
            "time" => now(),
        ]);
        

        try {
            if ($request->hasFile("photo_employe")) {
                if (Storage::exists($employe->photo_employe)) {
                    Storage::delete($employe->photo_employe);
                }
                $photo = $request->photo_employe;
                $name = $request->nom_employe." ".$request->prenom_employe;
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
}
