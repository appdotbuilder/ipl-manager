import React from 'react';
import AppLayout from '@/layouts/app-layout';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Head, Link } from '@inertiajs/react';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

interface MonthlyData {
    total_income?: number;
    total_expense?: number;
    [key: string]: unknown;
}

interface ActivityLog {
    id: number;
    action: string;
    entity_type: string;
    created_at: string;
    user?: {
        name: string;
    };
    [key: string]: unknown;
}

interface Props {
    stats: {
        total_residents: number;
        overdue_payments: number;
        unpaid_payments: number;
        current_year: number;
    };
    monthly_income: Record<string, MonthlyData>;
    monthly_expenses: Record<string, MonthlyData>;
    recent_activities: ActivityLog[];
    [key: string]: unknown;
}

export default function Dashboard({ stats, monthly_income, monthly_expenses, recent_activities }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard IPL" />
            
            <div className="space-y-8">
                {/* Header */}
                <div className="text-center">
                    <h1 className="text-3xl font-bold text-gray-900 mb-2">
                        🏘️ Sistem Manajemen IPL
                    </h1>
                    <p className="text-gray-600">
                        Kelola iuran pemeliharaan lingkungan dengan mudah dan efisien
                    </p>
                </div>

                {/* Navigation Cards */}
                <div className="grid lg:grid-cols-3 gap-6">
                    <Card className="bg-gradient-to-br from-blue-50 to-blue-100 border-blue-200 hover:shadow-lg transition-all cursor-pointer group">
                        <Link href={route('ipl.index')}>
                            <CardHeader className="pb-3">
                                <div className="flex items-center space-x-3">
                                    <div className="bg-blue-600 text-white p-3 rounded-lg group-hover:bg-blue-700 transition-colors">
                                        <span className="text-2xl">📊</span>
                                    </div>
                                    <div>
                                        <CardTitle className="text-blue-800">Input Data IPL</CardTitle>
                                        <p className="text-sm text-blue-600">Kelola pembayaran warga</p>
                                    </div>
                                </div>
                            </CardHeader>
                            <CardContent>
                                <div className="flex items-center justify-between">
                                    <div>
                                        <p className="text-2xl font-bold text-blue-700">{stats.total_residents}</p>
                                        <p className="text-sm text-blue-600">Total Warga</p>
                                    </div>
                                    {stats.overdue_payments > 0 && (
                                        <Badge variant="destructive">
                                            {stats.overdue_payments} Terlambat
                                        </Badge>
                                    )}
                                </div>
                            </CardContent>
                        </Link>
                    </Card>

                    <Card className="bg-gradient-to-br from-green-50 to-green-100 border-green-200 hover:shadow-lg transition-all cursor-pointer group">
                        <Link href={route('expenses.index')}>
                            <CardHeader className="pb-3">
                                <div className="flex items-center space-x-3">
                                    <div className="bg-green-600 text-white p-3 rounded-lg group-hover:bg-green-700 transition-colors">
                                        <span className="text-2xl">💸</span>
                                    </div>
                                    <div>
                                        <CardTitle className="text-green-800">Input Pengeluaran</CardTitle>
                                        <p className="text-sm text-green-600">Catat pengeluaran lingkungan</p>
                                    </div>
                                </div>
                            </CardHeader>
                            <CardContent>
                                <div className="flex items-center justify-between">
                                    <div>
                                        <p className="text-2xl font-bold text-green-700">
                                            {Object.values(monthly_expenses || {}).length}
                                        </p>
                                        <p className="text-sm text-green-600">Bulan dengan Data</p>
                                    </div>
                                    <Button size="sm" variant="outline" className="border-green-300 text-green-700">
                                        Tambah
                                    </Button>
                                </div>
                            </CardContent>
                        </Link>
                    </Card>

                    <Card className="bg-gradient-to-br from-purple-50 to-purple-100 border-purple-200 hover:shadow-lg transition-all cursor-pointer group">
                        <Link href={route('data-sync.index')}>
                            <CardHeader className="pb-3">
                                <div className="flex items-center space-x-3">
                                    <div className="bg-purple-600 text-white p-3 rounded-lg group-hover:bg-purple-700 transition-colors">
                                        <span className="text-2xl">☁️</span>
                                    </div>
                                    <div>
                                        <CardTitle className="text-purple-800">Update/Backup Data</CardTitle>
                                        <p className="text-sm text-purple-600">Sinkronisasi Google Sheets</p>
                                    </div>
                                </div>
                            </CardHeader>
                            <CardContent>
                                <div className="flex items-center justify-between">
                                    <div>
                                        <p className="text-2xl font-bold text-purple-700">
                                            {stats.current_year}
                                        </p>
                                        <p className="text-sm text-purple-600">Periode Aktif</p>
                                    </div>
                                    <Button size="sm" variant="outline" className="border-purple-300 text-purple-700">
                                        Sync
                                    </Button>
                                </div>
                            </CardContent>
                        </Link>
                    </Card>
                </div>

                {/* Stats Overview */}
                <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <Card>
                        <CardContent className="p-4">
                            <div className="flex items-center space-x-3">
                                <div className="bg-blue-100 p-2 rounded">
                                    <span className="text-lg">👥</span>
                                </div>
                                <div>
                                    <p className="text-2xl font-bold text-gray-900">{stats.total_residents}</p>
                                    <p className="text-sm text-gray-600">Total Warga</p>
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardContent className="p-4">
                            <div className="flex items-center space-x-3">
                                <div className="bg-orange-100 p-2 rounded">
                                    <span className="text-lg">⏳</span>
                                </div>
                                <div>
                                    <p className="text-2xl font-bold text-gray-900">{stats.unpaid_payments}</p>
                                    <p className="text-sm text-gray-600">Belum Bayar</p>
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardContent className="p-4">
                            <div className="flex items-center space-x-3">
                                <div className="bg-red-100 p-2 rounded">
                                    <span className="text-lg">⚠️</span>
                                </div>
                                <div>
                                    <p className="text-2xl font-bold text-gray-900">{stats.overdue_payments}</p>
                                    <p className="text-sm text-gray-600">Terlambat 3+ Bulan</p>
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardContent className="p-4">
                            <div className="flex items-center space-x-3">
                                <div className="bg-green-100 p-2 rounded">
                                    <span className="text-lg">📅</span>
                                </div>
                                <div>
                                    <p className="text-2xl font-bold text-gray-900">{stats.current_year}</p>
                                    <p className="text-sm text-gray-600">Periode Aktif</p>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                {/* Recent Activities */}
                <div className="grid lg:grid-cols-2 gap-6">
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center space-x-2">
                                <span>📋</span>
                                <span>Aktivitas Terbaru</span>
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-3">
                                {recent_activities?.length > 0 ? (
                                    recent_activities.slice(0, 5).map((activity, index) => (
                                        <div key={index} className="flex items-center justify-between py-2 border-b last:border-b-0">
                                            <div>
                                                <p className="font-medium text-sm">
                                                    {activity.action} {activity.entity_type}
                                                </p>
                                                <p className="text-xs text-gray-500">
                                                    oleh {activity.user?.name} • {new Date(activity.created_at).toLocaleDateString('id-ID')}
                                                </p>
                                            </div>
                                            <Badge variant="outline" className="text-xs">
                                                {activity.action}
                                            </Badge>
                                        </div>
                                    ))
                                ) : (
                                    <p className="text-gray-500 text-center py-4">Belum ada aktivitas</p>
                                )}
                            </div>
                            {recent_activities?.length > 5 && (
                                <div className="mt-4">
                                    <Link href={route('activity-logs.index')}>
                                        <Button variant="outline" size="sm" className="w-full">
                                            Lihat Semua Aktivitas
                                        </Button>
                                    </Link>
                                </div>
                            )}
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center space-x-2">
                                <span>📊</span>
                                <span>Ringkasan Keuangan {stats.current_year}</span>
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                <div className="flex items-center justify-between">
                                    <span className="text-sm text-gray-600">Total Pemasukan</span>
                                    <span className="font-semibold text-green-600">
                                        Rp {Object.values(monthly_income || {})
                                            .reduce((sum: number, item: MonthlyData) => sum + parseFloat(String(item.total_income || 0)), 0)
                                            .toLocaleString('id-ID')}
                                    </span>
                                </div>
                                <div className="flex items-center justify-between">
                                    <span className="text-sm text-gray-600">Total Pengeluaran</span>
                                    <span className="font-semibold text-red-600">
                                        Rp {Object.values(monthly_expenses || {})
                                            .reduce((sum: number, item: MonthlyData) => sum + parseFloat(String(item.total_expense || 0)), 0)
                                            .toLocaleString('id-ID')}
                                    </span>
                                </div>
                                <div className="border-t pt-2">
                                    <div className="flex items-center justify-between">
                                        <span className="text-sm font-medium">Saldo</span>
                                        <span className="font-bold text-blue-600">
                                            Rp {(
                                                Object.values(monthly_income || {}).reduce((sum: number, item: MonthlyData) => sum + parseFloat(String(item.total_income || 0)), 0) -
                                                Object.values(monthly_expenses || {}).reduce((sum: number, item: MonthlyData) => sum + parseFloat(String(item.total_expense || 0)), 0)
                                            ).toLocaleString('id-ID')}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </AppLayout>
    );
}