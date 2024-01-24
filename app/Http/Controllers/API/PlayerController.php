<?php

namespace App\Http\Controllers\API;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // On récupère tous les utilisateurs
        $players = Player::with(['club'])->get();
        // On retourne les informations des utilisateurs en JSON
        return response()->json($players);

        // On récupère tous les joueurs
        $players = DB::table('players')
            ->get()
            ->toArray();
        // On retourne les informations des utilisateurs en JSON
        return response()->json([
            'status' => 'Success',
            'data' => $players,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstName' => 'required|max:100',
            'lastName' => 'required|max:100',
            'height' => 'required|max:100',
            'position' => 'required|max:100',
        ]);
        $filename = "";
        if ($request->hasFile('photoPlayer')) {
            $filenameWithExt = $request->file('photoPlayer')->getClientOriginalName();
            $filenameWithoutExt = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('photoPlayer')->getClientOriginalExtension();
            $filename = $filenameWithoutExt . '_' . time() . '.' . $extension;
            $path = $request->file('photoPlayer')->storeAs('public/uploads', $filename);
        } else {
            $filename = Null;
        }
        $player = Player::create(array_merge($request->all(), ['photoPlayer' => $filename]));
        return response()->json([
            'status' => 'Success',
            'data' => $player,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Player $player)
    {
        // On retourne les informations de l'utilisateur en JSON
        return response()->json($player);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Player $player)
    {
        $this->validate($request, [
            'firstName' => 'required|max:100',
            'lastName' => 'required|max:100',
            'height' => 'required|max:100',
            'position' => 'required|max:100',
        ]);
        // On crée un nouvel utilisateur
        $player->update($request->all());
        //retourne les informations du nouvel utilisateur en JSON
        return response()->json([
            'status' => 'Mise à jour avec succèss'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        // On supprime l'utilisateur
        $player->delete();
        // On retourne la réponse JSON
        return response()->json([
            'status' => 'Supprimer avec succès avec succèss'
        ]);
    }
}
