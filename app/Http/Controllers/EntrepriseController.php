<?php

namespace App\Http\Controllers;

use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EntrepriseController extends Controller
{
    public function index() {
        $entreprises = Entreprise::orderBy("nom_entreprise", "ASC")->paginate(5);

        return inertia("Entreprise/IndexEntreprise", [
            "entreprises" => $entreprises
        ]);
    }

    public function modification(Entreprise $entreprise) {

        return response()->json(["entreprise" => $entreprise]);
    }

    public function store(Request $request) {
        $request->validate([
            "nom_entreprise" => "required|unique:App\\Models\Entreprise"
        ]);
        Entreprise::create(["nom_entreprise" => $request->nom_entreprise]);
        return redirect()->back();
    }

    public function update(Request $request, Entreprise $entreprise) {
        $request->validate([
            "nom_entreprise" => [
                "required",
                Rule::unique( (new Entreprise)->getTable(), "nom_entreprise" )->ignore($entreprise->id),
                ]
        ]);

        if($request->nom_entreprise != $entreprise->nom_entreprise){
            $entreprise->nom_entreprise = $request->nom_entreprise;
            $entreprise->save();
        }
        
        return redirect()->back();
    }

    public function delete(Entreprise $entreprise) {
        if (count($entreprise->employees) > 0) {
            return redirect()->back()->withErrors([
                "message" => "Cette entreprise ne peut pas etre supprimé car il se trouves des employes"
            ]);
        }
        $entreprise->delete();
        return redirect()->back();
    }
    
}
