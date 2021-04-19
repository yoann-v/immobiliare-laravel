<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            'properties' => Property::all(),
            //'properties' => Property::where('sold', 0)->get(),
        ]);
    }

    /**Affiche une annonce */
    public function show(Property $property)
    {
        //     $property = DB::table('properties')->find($id);

        // if (! $property) {
        //     abort(404);
        // }

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
            'image' => 'required|image',
            'price' =>'required|integer|gt:0',
        ]);
        
        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->image->store(
                'public/annonces', 
            );
        }
    
        /*DB::table('properties')->insert([
            'title' => $request->title,
            'description' => $request->description,
            'image' => str_replace('public', '/storage', $path),
            'price' => $request->price,
            'sold' => $request->filled('sold'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);*/

        Property::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => str_replace('public', '/storage', $path),
            'price' => $request->price,
            'sold' => $request->filled('sold'),
        ]);
        
    
        return redirect('/nos-annonces')->withInput();
    }

    /**Form pour éditer une annonce */
    public function edit($id)
    {
        /*$property = DB::table('properties')->find($id);

        if (! $property) {
            abort(404);
        }*/

        $property = Property::findOrFail($id);

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
        
        //DB::table('properties')->where('id', $id)
        Property::findOrFail($id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'sold' => $request->filled('sold'),
        ]);

        return redirect('/nos-annonces')
            ->with('message', 'Annonce mise à jour.');
    }

    /**Supprimer une annonce ds la bdd */
    public function destroy($id)
    {
        //$property = DB::table('properties')->find($id);
        $property = Property::findOrFail($id);

        if ($property->image) {
            Storage::delete(
                str_replace('/storage', 'public', $property->image)
            );     
        }

        //DB::table('properties')->delete($id);
        $property->delete();

        return redirect('/nos-annonces')
            ->with('message', 'Annonce supprimée.');
    }
}
