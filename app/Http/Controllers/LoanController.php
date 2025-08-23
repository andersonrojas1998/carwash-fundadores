<?php

namespace App\Http\Controllers;

use App\Model\Loan;
use App\User; // Corrige el namespace
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with('user')->get();
        $empleados = User::all();
        return view('loans.index', compact('loans', 'empleados'));
    }

    public function create()
    {
        return view('loans.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|integer',
            'valor' => 'required|numeric',
            'concepto' => 'required|string|max:255',
            'fecha_prestamo' => 'required|date'            
        ]);

        $loan = Loan::create($request->all());       
        if ($request->ajax()) {
            return response()->json(['success' => true, 'loan' => $loan]);
        }

        return redirect()->route('loans.index')->with('success', 'Préstamo creado correctamente.');
    }

    public function show($id)
    {
        $loan = Loan::with('user')->findOrFail($id);
        return response()->json($loan);
    }

    public function edit($id)
    {
        $loan = Loan::findOrFail($id);
        return response()->json($loan);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_usuario' => 'required|integer',
            'valor' => 'required|numeric',
            'concepto' => 'required|string|max:255',
            'fecha_prestamo' => 'required|date',
            'fecha_pago' => 'nullable|date',
        ]);

        $loan = Loan::findOrFail($id);
        $loan->update($request->all());

        if ($request->ajax()) {
            return response()->json(['success' => true, 'loan' => $loan]);
        }

        return redirect()->route('loans.index')->with('success', 'Préstamo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $loan = Loan::findOrFail($id);
        $loan->delete();

        return response()->json(['success' => true]);
    }
}
