<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIplPaymentRequest;
use App\Models\ActivityLog;
use App\Models\IplPayment;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class IplPaymentController extends Controller
{
    /**
     * Display a listing of IPL payments.
     */
    public function index(Request $request)
    {
        $query = IplPayment::with('resident');

        // Filter by search term
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('resident', function ($q) use ($search) {
                $q->where('nama_warga', 'like', "%{$search}%")
                  ->orWhere('blok_nomor_rumah', 'like', "%{$search}%");
            });
        }

        // Filter by year
        if ($request->filled('year')) {
            $query->where('tahun_periode', $request->year);
        }

        // Filter by month
        if ($request->filled('month')) {
            $query->where('bulan_ipl', $request->month);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_pembayaran', $request->status);
        }

        $iplPayments = $query->latest()->paginate(20)->withQueryString();

        // Get overdue payments (3+ months)
        $overduePayments = IplPayment::with('resident')
            ->overdue(3)
            ->get();

        return Inertia::render('ipl/index', [
            'ipl_payments' => $iplPayments,
            'overdue_payments' => $overduePayments,
            'filters' => $request->only(['search', 'year', 'month', 'status']),
            'years' => range(date('Y') - 5, date('Y') + 2),
            'months' => [
                'januari' => 'Januari',
                'februari' => 'Februari',
                'maret' => 'Maret',
                'april' => 'April',
                'mei' => 'Mei',
                'juni' => 'Juni',
                'juli' => 'Juli',
                'agustus' => 'Agustus',
                'september' => 'September',
                'oktober' => 'Oktober',
                'november' => 'November',
                'desember' => 'Desember',
            ],
        ]);
    }

    /**
     * Show the form for creating a new IPL payment.
     */
    public function create()
    {
        $residents = Resident::active()->orderBy('blok_nomor_rumah')->get();
        
        return Inertia::render('ipl/create', [
            'residents' => $residents,
            'months' => [
                'januari' => 'Januari',
                'februari' => 'Februari',
                'maret' => 'Maret',
                'april' => 'April',
                'mei' => 'Mei',
                'juni' => 'Juni',
                'juli' => 'Juli',
                'agustus' => 'Agustus',
                'september' => 'September',
                'oktober' => 'Oktober',
                'november' => 'November',
                'desember' => 'Desember',
            ],
            'preset_amounts' => [
                90000 => 'Rp 90.000 (Standard)',
                75000 => 'Rp 75.000 (Khusus)',
                60000 => 'Rp 60.000 (Khusus)',
            ],
        ]);
    }

    /**
     * Store a newly created IPL payment.
     */
    public function store(StoreIplPaymentRequest $request)
    {
        // Check for duplicate entry
        $existingPayment = IplPayment::where('resident_id', $request->resident_id)
            ->where('tahun_periode', $request->tahun_periode)
            ->where('bulan_ipl', $request->bulan_ipl)
            ->first();

        if ($existingPayment) {
            return redirect()->back()
                ->withErrors(['duplicate' => 'Data IPL untuk warga ini pada periode yang sama sudah ada.'])
                ->withInput()
                ->with('existing_payment', $existingPayment->load('resident'));
        }

        // Generate sequential nomor
        $lastPayment = IplPayment::orderBy('nomor', 'desc')->first();
        $nextNomor = $lastPayment ? $lastPayment->nomor + 1 : 1;

        // Create the payment
        $validatedData = $request->validated();
        $validatedData['nomor'] = $nextNomor;
        
        $iplPayment = IplPayment::create($validatedData);

        // Log the activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'created',
            'entity_type' => 'IplPayment',
            'entity_id' => $iplPayment->id,
            'new_values' => $iplPayment->toArray(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('ipl.index')
            ->with('success', 'Data IPL berhasil ditambahkan.');
    }

    /**
     * Display the specified IPL payment.
     */
    public function show(IplPayment $ipl)
    {
        $ipl->load('resident');
        
        return Inertia::render('ipl/show', [
            'ipl_payment' => $ipl,
        ]);
    }

    /**
     * Show the form for editing the specified IPL payment.
     */
    public function edit(IplPayment $ipl)
    {
        $ipl->load('resident');
        $residents = Resident::active()->orderBy('blok_nomor_rumah')->get();
        
        return Inertia::render('ipl/edit', [
            'ipl_payment' => $ipl,
            'residents' => $residents,
            'months' => [
                'januari' => 'Januari',
                'februari' => 'Februari',
                'maret' => 'Maret',
                'april' => 'April',
                'mei' => 'Mei',
                'juni' => 'Juni',
                'juli' => 'Juli',
                'agustus' => 'Agustus',
                'september' => 'September',
                'oktober' => 'Oktober',
                'november' => 'November',
                'desember' => 'Desember',
            ],
            'preset_amounts' => [
                90000 => 'Rp 90.000 (Standard)',
                75000 => 'Rp 75.000 (Khusus)',
                60000 => 'Rp 60.000 (Khusus)',
            ],
        ]);
    }

    /**
     * Update the specified IPL payment.
     */
    public function update(StoreIplPaymentRequest $request, IplPayment $ipl)
    {
        // Check for duplicate entry (excluding current record)
        $existingPayment = IplPayment::where('resident_id', $request->resident_id)
            ->where('tahun_periode', $request->tahun_periode)
            ->where('bulan_ipl', $request->bulan_ipl)
            ->where('id', '!=', $ipl->id)
            ->first();

        if ($existingPayment) {
            return redirect()->back()
                ->withErrors(['duplicate' => 'Data IPL untuk warga ini pada periode yang sama sudah ada.'])
                ->withInput()
                ->with('existing_payment', $existingPayment->load('resident'));
        }

        $oldValues = $ipl->toArray();
        $ipl->update($request->validated());

        // Log the activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'updated',
            'entity_type' => 'IplPayment',
            'entity_id' => $ipl->id,
            'old_values' => $oldValues,
            'new_values' => $ipl->toArray(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('ipl.show', $ipl)
            ->with('success', 'Data IPL berhasil diperbarui.');
    }

    /**
     * Remove the specified IPL payment.
     */
    public function destroy(IplPayment $ipl)
    {
        $oldValues = $ipl->toArray();
        $ipl->delete();

        // Log the activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'deleted',
            'entity_type' => 'IplPayment',
            'entity_id' => $ipl->id,
            'old_values' => $oldValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('ipl.index')
            ->with('success', 'Data IPL berhasil dihapus.');
    }
}