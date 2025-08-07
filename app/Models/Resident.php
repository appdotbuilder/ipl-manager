<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Resident
 *
 * @property int $id
 * @property string $nama_warga
 * @property string $blok_nomor_rumah
 * @property float $default_nominal_ipl
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\IplPayment> $iplPayments
 * @property-read int|null $ipl_payments_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Resident newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Resident newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Resident query()
 * @method static \Illuminate\Database\Eloquent\Builder|Resident whereBlokNomorRumah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resident whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resident whereDefaultNominalIpl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resident whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resident whereNamaWarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resident whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resident whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resident active()
 * @method static \Database\Factories\ResidentFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Resident extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_warga',
        'blok_nomor_rumah',
        'default_nominal_ipl',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'default_nominal_ipl' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the IPL payments for this resident.
     */
    public function iplPayments(): HasMany
    {
        return $this->hasMany(IplPayment::class);
    }

    /**
     * Scope a query to only include active residents.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get formatted IPL amount.
     *
     * @return string
     */
    public function getFormattedIplAttribute(): string
    {
        return 'Rp ' . number_format($this->default_nominal_ipl, 0, ',', '.');
    }
}