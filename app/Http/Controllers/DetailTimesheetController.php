<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use App\Models\DetailTimesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\TimesheetTemplateExport;
use Carbon\Carbon;

class DetailTimesheetController extends Controller
{
    /**
     * HALAMAN DETAIL TIMESHEET
     */
    public function index(Request $request, $id)
    {
        $timesheet = Timesheet::with([
            'transaksi.pelanggan',
            'transaksi.alat'
        ])->findOrFail($id);

        // TOTAL JAM BAKET
        $totalJamBaket = DetailTimesheet::where(
            'timesheet_id',
            $id
        )->sum('jam_baket');

        // TOTAL JAM BREKER
        $totalJamBreker = DetailTimesheet::where(
            'timesheet_id',
            $id
        )->sum('jam_breker');

        if ($request->ajax()) {

            $data = DetailTimesheet::where(
                'timesheet_id',
                $id
            )->orderBy(
                'tanggal_pekerjaan',
                'desc'
            );

            return DataTables::of($data)

                ->addIndexColumn()

                ->editColumn(
                    'tanggal_pekerjaan',
                    function ($row) {

                        return Carbon::parse($row->tanggal_pekerjaan);
                    }
                )

                ->addColumn('gambar', function ($row) {

                    if ($row->gambar) {

                        $url = asset(
                            'storage/' . $row->gambar
                        );

                        return '
                            <img
                                src="' . $url . '"
                                width="50"
                                height="50"
                                class="rounded shadow-sm"
                                style="object-fit:cover;cursor:pointer"
                                onclick="showGambar(\'' . $url . '\')"
                            >
                        ';
                    }

                    return '<small class="text-muted">No Image</small>';
                })

                ->addColumn('action', function ($row) {

                    return '
                        <button
                            type="button"
                            onclick="editDetail(\''.$row->id.'\')"
                            class="btn btn-primary btn-icon btn-xs">

                            <i class="mdi mdi-lead-pencil"></i>

                        </button>

                        <button
                            type="button"
                            onclick="deleteDetail(\''.$row->timesheet_id.'\', \''.$row->id.'\')"
                            class="btn btn-danger btn-icon btn-xs">

                            <i class="mdi mdi-delete"></i>

                        </button>
                    ';
                })

                ->rawColumns([
                    'gambar',
                    'action'
                ])

                ->make(true);
        }

        return view(
            'timesheet.detail.index',
            compact(
                'timesheet',
                'totalJamBaket',
                'totalJamBreker'
            )
        );
    }

    /**
     * STORE
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'timesheet_id' => 'required|exists:timesheets,id',

            'tanggal_pekerjaan' => 'required|date',

            'jam_baket' => 'nullable|integer|min:0',

            'hm_awal' => 'required|integer|min:0',

            'hm_akhir' => 'required|integer|min:0',

            'jam_breker' => 'nullable|integer|min:0',

            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('gambar')) {

            $validated['gambar'] = $request
                ->file('gambar')
                ->store(
                    'detail_timesheet',
                    'public'
                );
        }

        DetailTimesheet::create($validated);

        $totalJamBaket = DetailTimesheet::where(
            'timesheet_id',
            $validated['timesheet_id']
        )->sum('jam_baket');

        $totalJamBreker = DetailTimesheet::where(
            'timesheet_id',
            $validated['timesheet_id']
        )->sum('jam_breker');

        return response()->json([

            'success' => true,

            'message' => 'Detail timesheet berhasil ditambahkan!',

            'totalJamBaket' => $totalJamBaket,

            'totalJamBreker' => $totalJamBreker
        ]);
    }

    /**
     * EDIT
     */
    public function edit($timesheetId, $id)
    {
        $detail = DetailTimesheet::findOrFail($id);

        return response()->json($detail);
    }

    /**
     * UPDATE
     */
    public function update(
        Request $request,
        $timesheetId,
        $id
    ) {
        $detail = DetailTimesheet::findOrFail($id);

        $validated = $request->validate([

            'tanggal_pekerjaan' => 'required|date',

            'jam_baket' => 'nullable|integer|min:0',

            'hm_awal' => 'required|integer|min:0',

            'hm_akhir' => 'required|integer|min:0',

            'jam_breker' => 'nullable|integer|min:0',

            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('gambar')) {

            if ($detail->gambar) {

                Storage::disk('public')
                    ->delete($detail->gambar);
            }

            $validated['gambar'] = $request
                ->file('gambar')
                ->store(
                    'detail_timesheet',
                    'public'
                );
        }

        $detail->update($validated);

        $totalJamBaket = DetailTimesheet::where(
            'timesheet_id',
            $timesheetId
        )->sum('jam_baket');

        $totalJamBreker = DetailTimesheet::where(
            'timesheet_id',
            $timesheetId
        )->sum('jam_breker');

        return response()->json([

            'success' => true,

            'message' => 'Detail timesheet berhasil diupdate!',

            'totalJamBaket' => $totalJamBaket,

            'totalJamBreker' => $totalJamBreker
        ]);
    }

    /**
     * DELETE
     */
    public function destroy(
        $timesheetId,
        $id
    ) {
        $detail = DetailTimesheet::findOrFail($id);

        if ($detail->gambar) {

            Storage::disk('public')
                ->delete($detail->gambar);
        }

        $detail->delete();

        $totalJamBaket = DetailTimesheet::where(
            'timesheet_id',
            $timesheetId
        )->sum('jam_baket');

        $totalJamBreker = DetailTimesheet::where(
            'timesheet_id',
            $timesheetId
        )->sum('jam_breker');

        return response()->json([

            'success' => true,

            'message' => 'Detail timesheet berhasil dihapus!',

            'totalJamBaket' => $totalJamBaket,

            'totalJamBreker' => $totalJamBreker
        ]);
    }

    public function export($transaksiId)
    {
        $export = new TimesheetTemplateExport();

        return $export->export($transaksiId);
    }
}