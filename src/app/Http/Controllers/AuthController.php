<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Person;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Find user by email
        $user = User::where('email', $request->email)->first();

        // Check if user exists and password is correct
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Retrieve user's role (tp_person) from the person table
        $person = Person::where('user_id', $user->id)->with('personSupplier')->with('personCustomer')->first();

        if (!$person) {
            return response()->json(['message' => 'User role not found'], 404);
        }

        // Generate token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return user info and token
        return response()->json([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'tp_person' => $person->tp_person, // 1 = Customer, 2 = Supplier
            'person_id' => $person->person_id,
            'personsupplier_id' => $person->PersonSupplier->personsupplier_id ?? null,
            'personcustomer_id' => $person->PersonSupplier->personcustomer_id ?? null,
            'token' => $token
        ]);
    }
}
