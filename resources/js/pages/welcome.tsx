import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';

interface Props {
    stats?: {
        total_residents: number;
        overdue_payments: number;
        unpaid_payments: number;
        current_year: number;
    };
    monthly_income?: Record<string, unknown>;
    monthly_expenses?: Record<string, unknown>;
    recent_activities?: unknown[];
    [key: string]: unknown;
}

export default function Welcome({ stats }: Props) {
    return (
        <>
            <Head title="IPL Management System" />
            
            <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50">
                {/* Header */}
                <header className="bg-white shadow-sm border-b">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                        <div className="flex items-center justify-between">
                            <div className="flex items-center space-x-4">
                                <div className="bg-blue-100 p-3 rounded-lg">
                                    <span className="text-2xl">🏘️</span>
                                </div>
                                <div>
                                    <h1 className="text-2xl font-bold text-gray-900">
                                        Sistem Manajemen IPL
                                    </h1>
                                    <p className="text-gray-600">
                                        Kelola Iuran Pemeliharaan Lingkungan dengan Mudah
                                    </p>
                                </div>
                            </div>
                            <div className="flex items-center space-x-3">
                                <Link href={route('login')}>
                                    <Button variant="outline">
                                        Masuk
                                    </Button>
                                </Link>
                                <Link href={route('register')}>
                                    <Button>
                                        Daftar
                                    </Button>
                                </Link>
                            </div>
                        </div>
                    </div>
                </header>

                {/* Main Content */}
                <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    {/* Hero Section */}
                    <div className="text-center mb-16">
                        <div className="inline-flex items-center bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-medium mb-6">
                            ✨ Sistem Terintegrasi dengan PostgreSQL & Google Sheets
                        </div>
                        <h2 className="text-5xl font-bold text-gray-900 mb-6">
                            💰 Kelola IPL Warga<br />
                            <span className="text-blue-600">Secara Digital</span>
                        </h2>
                        <p className="text-xl text-gray-600 max-w-3xl mx-auto mb-8">
                            Platform komprehensif untuk mengelola iuran pemeliharaan lingkungan (IPL) 
                            dengan fitur pencatatan, pelaporan, dan sinkronisasi data yang lengkap.
                        </p>
                        
                        {/* Quick Stats */}
                        {stats && (
                            <div className="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-2xl mx-auto mb-8">
                                <div className="bg-white rounded-lg p-4 shadow-sm border">
                                    <div className="text-2xl font-bold text-blue-600">{stats.total_residents}</div>
                                    <div className="text-sm text-gray-600">Total Warga</div>
                                </div>
                                <div className="bg-white rounded-lg p-4 shadow-sm border">
                                    <div className="text-2xl font-bold text-orange-600">{stats.unpaid_payments}</div>
                                    <div className="text-sm text-gray-600">Belum Bayar</div>
                                </div>
                                <div className="bg-white rounded-lg p-4 shadow-sm border">
                                    <div className="text-2xl font-bold text-red-600">{stats.overdue_payments}</div>
                                    <div className="text-sm text-gray-600">Terlambat 3+ Bulan</div>
                                </div>
                                <div className="bg-white rounded-lg p-4 shadow-sm border">
                                    <div className="text-2xl font-bold text-green-600">{stats.current_year}</div>
                                    <div className="text-sm text-gray-600">Periode Aktif</div>
                                </div>
                            </div>
                        )}

                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            <Link href={route('login')}>
                                <Button size="lg" className="bg-blue-600 hover:bg-blue-700">
                                    🚀 Mulai Kelola IPL
                                </Button>
                            </Link>
                            <Link href={route('register')}>
                                <Button size="lg" variant="outline">
                                    📝 Daftar Sekarang
                                </Button>
                            </Link>
                        </div>
                    </div>

                    {/* Main Features */}
                    <div className="grid lg:grid-cols-3 gap-8 mb-16">
                        <Card className="bg-gradient-to-br from-blue-50 to-blue-100 border-blue-200 hover:shadow-lg transition-shadow">
                            <CardHeader>
                                <div className="flex items-center space-x-3">
                                    <div className="bg-blue-600 text-white p-3 rounded-lg">
                                        <span className="text-2xl">📊</span>
                                    </div>
                                    <CardTitle className="text-blue-800">Input Data IPL</CardTitle>
                                </div>
                            </CardHeader>
                            <CardContent>
                                <p className="text-blue-700 mb-4">
                                    Kelola pembayaran IPL warga dengan sistem anti-duplikasi dan pencarian yang mudah.
                                </p>
                                <div className="space-y-2">
                                    <div className="flex items-center text-sm text-blue-600">
                                        <span className="mr-2">✅</span> Pencarian berdasarkan nama/blok
                                    </div>
                                    <div className="flex items-center text-sm text-blue-600">
                                        <span className="mr-2">✅</span> Nominal fleksibel (Rp 90k, 75k, 60k)
                                    </div>
                                    <div className="flex items-center text-sm text-blue-600">
                                        <span className="mr-2">✅</span> Deteksi duplikasi otomatis
                                    </div>
                                    <div className="flex items-center text-sm text-blue-600">
                                        <span className="mr-2">✅</span> Status rumah kosong/bebas IPL
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        <Card className="bg-gradient-to-br from-green-50 to-green-100 border-green-200 hover:shadow-lg transition-shadow">
                            <CardHeader>
                                <div className="flex items-center space-x-3">
                                    <div className="bg-green-600 text-white p-3 rounded-lg">
                                        <span className="text-2xl">💸</span>
                                    </div>
                                    <CardTitle className="text-green-800">Input Pengeluaran</CardTitle>
                                </div>
                            </CardHeader>
                            <CardContent>
                                <p className="text-green-700 mb-4">
                                    Catat semua pengeluaran untuk transparansi keuangan lingkungan.
                                </p>
                                <div className="space-y-2">
                                    <div className="flex items-center text-sm text-green-600">
                                        <span className="mr-2">✅</span> Kategorisasi pengeluaran
                                    </div>
                                    <div className="flex items-center text-sm text-green-600">
                                        <span className="mr-2">✅</span> Filter berdasarkan tanggal
                                    </div>
                                    <div className="flex items-center text-sm text-green-600">
                                        <span className="mr-2">✅</span> Laporan pengeluaran bulanan
                                    </div>
                                    <div className="flex items-center text-sm text-green-600">
                                        <span className="mr-2">✅</span> Perbandingan pemasukan vs pengeluaran
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        <Card className="bg-gradient-to-br from-purple-50 to-purple-100 border-purple-200 hover:shadow-lg transition-shadow">
                            <CardHeader>
                                <div className="flex items-center space-x-3">
                                    <div className="bg-purple-600 text-white p-3 rounded-lg">
                                        <span className="text-2xl">☁️</span>
                                    </div>
                                    <CardTitle className="text-purple-800">Sinkronisasi Data</CardTitle>
                                </div>
                            </CardHeader>
                            <CardContent>
                                <p className="text-purple-700 mb-4">
                                    Integrasi dengan Google Sheets untuk backup dan sinkronisasi data.
                                </p>
                                <div className="space-y-2">
                                    <div className="flex items-center text-sm text-purple-600">
                                        <span className="mr-2">✅</span> Import dari Excel/Google Sheets
                                    </div>
                                    <div className="flex items-center text-sm text-purple-600">
                                        <span className="mr-2">✅</span> Backup otomatis dengan timestamp
                                    </div>
                                    <div className="flex items-center text-sm text-purple-600">
                                        <span className="mr-2">✅</span> Update data ke Google Sheets
                                    </div>
                                    <div className="flex items-center text-sm text-purple-600">
                                        <span className="mr-2">✅</span> Riwayat sinkronisasi lengkap
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                    </div>

                    {/* Additional Features */}
                    <div className="bg-white rounded-xl shadow-lg p-8 mb-16 border">
                        <h3 className="text-2xl font-bold text-gray-900 text-center mb-8">
                            🎯 Fitur Lengkap untuk Pengelolaan IPL
                        </h3>
                        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div className="flex items-start space-x-4">
                                <div className="bg-orange-100 p-2 rounded-lg">
                                    <span className="text-lg">⚠️</span>
                                </div>
                                <div>
                                    <h4 className="font-semibold text-gray-900">Deteksi Tunggakan</h4>
                                    <p className="text-sm text-gray-600">
                                        Otomatis mendeteksi warga yang terlambat bayar IPL 3+ bulan
                                    </p>
                                </div>
                            </div>
                            
                            <div className="flex items-start space-x-4">
                                <div className="bg-blue-100 p-2 rounded-lg">
                                    <span className="text-lg">📈</span>
                                </div>
                                <div>
                                    <h4 className="font-semibold text-gray-900">Laporan Pendapatan</h4>
                                    <p className="text-sm text-gray-600">
                                        Rangkuman pendapatan bulanan dari semua pembayaran IPL
                                    </p>
                                </div>
                            </div>
                            
                            <div className="flex items-start space-x-4">
                                <div className="bg-green-100 p-2 rounded-lg">
                                    <span className="text-lg">📋</span>
                                </div>
                                <div>
                                    <h4 className="font-semibold text-gray-900">Log Aktivitas</h4>
                                    <p className="text-sm text-gray-600">
                                        Catatan lengkap setiap aktivitas admin (siapa, apa, kapan)
                                    </p>
                                </div>
                            </div>
                            
                            <div className="flex items-start space-x-4">
                                <div className="bg-red-100 p-2 rounded-lg">
                                    <span className="text-lg">🔒</span>
                                </div>
                                <div>
                                    <h4 className="font-semibold text-gray-900">Sistem Keamanan</h4>
                                    <p className="text-sm text-gray-600">
                                        Autentikasi pengguna dan log IP address untuk keamanan data
                                    </p>
                                </div>
                            </div>
                            
                            <div className="flex items-start space-x-4">
                                <div className="bg-indigo-100 p-2 rounded-lg">
                                    <span className="text-lg">🎨</span>
                                </div>
                                <div>
                                    <h4 className="font-semibold text-gray-900">Interface Modern</h4>
                                    <p className="text-sm text-gray-600">
                                        Antarmuka yang responsive dan mudah digunakan di semua perangkat
                                    </p>
                                </div>
                            </div>
                            
                            <div className="flex items-start space-x-4">
                                <div className="bg-yellow-100 p-2 rounded-lg">
                                    <span className="text-lg">⚡</span>
                                </div>
                                <div>
                                    <h4 className="font-semibold text-gray-900">Performa Tinggi</h4>
                                    <p className="text-sm text-gray-600">
                                        Berbasis PostgreSQL dengan indeks yang optimal untuk performa cepat
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Technology Stack */}
                    <div className="text-center">
                        <h3 className="text-xl font-bold text-gray-900 mb-6">
                            🛠️ Dibangun dengan Teknologi Modern
                        </h3>
                        <div className="flex flex-wrap justify-center gap-3">
                            <Badge variant="secondary" className="px-4 py-2">
                                Laravel 11
                            </Badge>
                            <Badge variant="secondary" className="px-4 py-2">
                                React + TypeScript
                            </Badge>
                            <Badge variant="secondary" className="px-4 py-2">
                                PostgreSQL
                            </Badge>
                            <Badge variant="secondary" className="px-4 py-2">
                                Inertia.js
                            </Badge>
                            <Badge variant="secondary" className="px-4 py-2">
                                Google Sheets API
                            </Badge>
                            <Badge variant="secondary" className="px-4 py-2">
                                Tailwind CSS
                            </Badge>
                        </div>
                    </div>
                </main>

                {/* Footer */}
                <footer className="bg-gray-50 border-t mt-20">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                        <div className="text-center">
                            <p className="text-gray-600">
                                © 2024 Sistem Manajemen IPL. Platform digital untuk pengelolaan iuran lingkungan yang efektif.
                            </p>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}