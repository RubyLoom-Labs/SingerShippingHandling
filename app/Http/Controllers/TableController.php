<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\TableRow;
use App\Models\User;
use Illuminate\Http\Request;

class TableController extends Controller
{
    // Display all tables
    public function index()
    {
        $tables = Table::where('status', 'ACTIVE')->latest()->get();
        return view('dashboard', compact('tables'));
    }

    // Store new table
    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000'
            ]);

            $validated['status'] = 'ACTIVE';
            Table::create($validated);

            return redirect()->back()->with('success', 'Table created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create table: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function show($id)
    {
        try {
            $table = Table::findOrFail($id);

            $shippingAgents = User::where(['status' => 'ACTIVE', 'user_type' => 2])
                ->orderBy('name', 'asc')
                ->get();

            $clearanceAgents = User::where(['status' => 'ACTIVE', 'user_type' => 3])
                ->orderBy('name', 'asc')
                ->get();

            // Load rows with the agent relationships
            $rows = '';
            if (auth()->user()->user_type == 1) {
                $rows = TableRow::where('table_id', $id)
                    ->with(['shippingAgent', 'clearanceAgent'])  // Add this line
                    ->orderBy('id', 'asc')
                    ->get();
            } elseif (auth()->user()->user_type == 2) {
                $rows = TableRow::where(['table_id' => $id, 'shipping_agent_id' => auth()->user()->id])
                    ->with(['shippingAgent', 'clearanceAgent'])  // Add this line
                    ->orderBy('id', 'asc')
                    ->get();
            } elseif (auth()->user()->user_type == 3) {
                $rows = TableRow::where(['table_id' => $id, 'clearance_agent_id' => auth()->user()->id])
                    ->with(['shippingAgent', 'clearanceAgent'])  // Add this line
                    ->orderBy('id', 'asc')
                    ->get();
            }
            $table->rows = $rows;

            return view('table-show', compact('table', 'shippingAgents', 'clearanceAgents'));
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Table not found!');
        }
    }

    // Update table
    public function update(Request $request, $id)
    {
        try {
            $table = Table::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000'
            ]);

            $table->update($validated);

            return redirect()->back()->with('success', 'Table updated successfully!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Table not found!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update table: ' . $e->getMessage());
        }
    }

    // Soft delete table (set status to INACTIVE)
    public function destroy($id)
    {
        try {
            $table = Table::findOrFail($id);
            $table->update(['status' => 'INACTIVE']);

            return redirect()->back()->with('success', 'Table deleted successfully!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Table not found!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete table: ' . $e->getMessage());
        }
    }

    // Store new row
    public function storeRow(Request $request, $tableId)
    {
        try {
            $validated = $request->validate([
                'category' => 'nullable|string|max:255',
                'part_no' => 'nullable|string|max:255',
                'brand_name' => 'nullable|string|max:255',
                'unit' => 'nullable|string|max:255',
                'po_number' => 'nullable|string|max:255',
                'vsl' => 'nullable|string|max:255',
                'bl_num' => 'nullable|string|max:255',
                'etd' => 'nullable|date',
                'revised_etd' => 'nullable|date',
                'eta' => 'nullable|date',
                'revised_eta' => 'nullable|date',
                'cleared_date' => 'nullable|date',
                'clearance_agent_id' => 'nullable|integer',
                'shipping_agent_id' => 'nullable|integer',
            ]);

            $validated['table_id'] = $tableId;
            TableRow::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Row added successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add row: ' . $e->getMessage()
            ], 500);
        }
    }

    // Update row
    public function updateRow(Request $request, $tableId, $rowId)
    {
        try {
            $row = TableRow::where('table_id', $tableId)->findOrFail($rowId);

            $validated = $request->validate([
                'category' => 'nullable|string|max:255',
                'part_no' => 'nullable|string|max:255',
                'brand_name' => 'nullable|string|max:255',
                'unit' => 'nullable|string|max:255',
                'po_number' => 'nullable|string|max:255',
                'vsl' => 'nullable|string|max:255',
                'bl_num' => 'nullable|string|max:255',
                'etd' => 'nullable|date',
                'revised_etd' => 'nullable|date',
                'eta' => 'nullable|date',
                'revised_eta' => 'nullable|date',
                'cleared_date' => 'nullable|date',
                'clearance_agent_id' => 'nullable|integer',
                'shipping_agent_id' => 'nullable|integer',
            ]);

            $row->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Row updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update row: ' . $e->getMessage()
            ], 500);
        }
    }

    // Delete row
    public function destroyRow($tableId, $rowId)
    {
        try {
            $row = TableRow::where('table_id', $tableId)->findOrFail($rowId);
            $row->delete();

            return response()->json([
                'success' => true,
                'message' => 'Row deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete row: ' . $e->getMessage()
            ], 500);
        }
    }
}
