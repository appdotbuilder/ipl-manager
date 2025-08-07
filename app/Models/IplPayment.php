<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\IplPayment
 *
 * @property int $id
 * @property int $nomor
 * @property int $resident_id
 * @property float $nominal_ipl
 * @property int $tahun_periode
 * @property string $bulan_ipl
 * @property string $status_pembayaran
 * @property bool $rumah_kosong
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Resident $resident
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|IplPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IplPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IplPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|IplPayment whereBulanIpl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IplPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IplPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IplPayment whereNominalIpl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IplPayment whereNomor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IplPayment whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IplPayment whereResidentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IplPayment whereRumahKosong($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IplPayment whereStatusPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IplPayment whereTahunPeriode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IplPayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IplPayment overdue($months = 3)
 * @method static \Illuminate\Database\Eloquent\Builder|IplPayment paid()
 * @method static \Illuminate\Database\Eloquent\Builder|IplPayment unpaid()
 * @method static \Database\Factories\IplPaymentFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class IplPayment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nomor',
        'resident_id',
        'nominal_ipl',
        'tahun_periode',
        'bulan_ipl',
        'status_pembayaran',
        'rumah_kosong',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'nominal_ipl' => 'decimal:2',
        'tahun_periode' => 'integer',
        'rumah_kosong' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the resident that owns this payment.
     */
    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }

    /**
     * Scope a query to only include paid payments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePaid($query)
    {
        return $query->where('status_pembayaran', 'paid');
    }

    /**
     * Scope a query to only include unpaid payments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnpaid($query)
    {
        return $query->where('status_pembayaran', 'unpaid');
    }

    /**
     * Scope a query to find overdue payments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $months
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOverdue($query, $months = 3)
    {
        $cutoffDate = now()->subMonths($months);
        return $query->where('status_pembayaran', 'unpaid')
                    ->where('created_at', '<', $cutoffDate);
    }

    /**
     * Get formatted IPL amount.
     *
     * @return string
     */
    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->nominal_ipl, 0, ',', '.');
    }

    /**
     * Get formatted month name in Indonesian.
     *
     * @return string
     */
    public function getFormattedMonthAttribute(): string
    {
        $months = [
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
        ];
        
        return $months[$this->bulan_ipl] ?? $this->bulan_ipl;
    }
}