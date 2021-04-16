<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    /**Affiche la liste des annonces */
    public function index()
    {
        $properties = DB::select('select * from properties where sold = :sold', [
            'sold' => 0,
        ]);
    
        $properties = DB::table('properties')
            ->where('sold', 0)->where('sold', '=', 1, 'or')->get();
    
        return view('properties/index', [
            'properties' => $properties,
        ]);
    }

    /**Affiche une annonce */
    public function show($id)
    {
            $property = DB::table('properties')->find($id);

        if (! $property) {
            abort(404);
        }

        return view('properties/show', ['property' => $property]);
    }

    /**Form pour créer une annonce */
    public function create()
    {
        return view('properties/create');
    }

    /**Enregistre annonce ds la bdd */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|unique:properties|min:2',
            'description' => 'required|string|min:15',
            'price' =>'required|integer|gt:0',
        ]);
    
        DB::table('properties')->insert([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'sold' => $request->filled('sold'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return redirect('/nos-annonces')->withInput();
    }

    /**Form pour éditer une annonce */
    public function edit($id)
    {
        $property = DB::table('properties')->find($id);

        if (! $property) {
            abort(404);
        }

        return view('properties/edit', ['property' => $property]);
    }

    /**Mofifier une annonce ds la bdd */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|unique:properties,title,'.$id.'|min:2',
            'description' => 'required|string|min:15',
            'price' =>'required|integer|gt:0',
        ]);

        DB::table('properties')->where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'sold' => $request->filled('sold'),
            'updated_at' => now(),
        ]);

        return redirect('/nos-annonces')
            ->with('message', 'Annonce mise à jour.');
    }

    /**Supprimer une annonce ds la bdd */
    public function destroy($id)
    {
        DB::table('properties')->delete($id);

        return redirect('/nos-annonces')
            ->with('message', 'Annonce supprimée.');
    }
}
