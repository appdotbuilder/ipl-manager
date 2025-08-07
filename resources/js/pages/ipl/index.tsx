import React from 'react';
import AppLayout from '@/layouts/app-layout';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Head, Link, router } from '@inertiajs/react';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Data IPL',
        href: '/ipl',
    },
];

interface IplPayment {
    id: number;
    nomor: number;
    resident: {
        id: number;
        nama_warga: string;
        blok_nomor_rumah: string;
    };
    nominal_ipl: string;
    tahun_periode: number;
    bulan_ipl: string;
    formatted_month: string;
    status_pembayaran: string;
    rumah_kosong: boolean;
    formatted_amount: string;
    created_at: string;
}

interface PaginationLink {
    url?: string;
    label: string;
    active: boolean;
}

interface PaginationMeta {
    total: number;
    from?: number;
    to?: number;
}

interface Props {
    ipl_payments: {
        data: IplPayment[];
        links: PaginationLink[];
        meta: PaginationMeta;
    };
    overdue_payments: IplPayment[];
    filters: {
        search?: string;
        year?: string;
        month?: string;
        status?: string;
    };
    years: number[];
    months: Record<string, string>;
    [key: string]: unknown;
}

export default function IplIndex({ ipl_payments, overdue_payments, filters, years, months }: Props) {
    const [searchTerm, setSearchTerm] = React.useState(filters.search || '');

    const handleFilter = (key: keyof typeof filters, value: string) => {
        const newFilters = { ...filters, [key]: value };
        if (!value) {
            delete newFilters[key];
        }
        router.get(route('ipl.index'), newFilters, { 
            preserveState: true, 
            preserveScroll: true 
        });
    };

    const handleSearch = (e: React.FormEvent) => {
        e.preventDefault();
        handleFilter('search', searchTerm);
    };

    const getStatusBadge = (status: string, rumahKosong: boolean) => {
        if (rumahKosong) {
            return <Badge variant="secondary">Exempt</Badge>;
        }
        
        switch (status) {
            case 'paid':
                return <Badge className="bg-green-100 text-green-800">Lunas</Badge>;
            case 'unpaid':
                return <Badge variant="destructive">Belum Bayar</Badge>;
            case 'exempt':
                return <Badge variant="secondary">Bebas IPL</Badge>;
            default:
                return <Badge variant="outline">{status}</Badge>;
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Data IPL" />
            
            <div className="space-y-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900">📊 Data IPL</h1>
                        <p className="text-gray-600">Kelola pembayaran iuran pemeliharaan lingkungan</p>
                    </div>
                    <Link href={route('ipl.create')}>
                        <Button>
                            ➕ Tambah Data IPL
                        </Button>
                    </Link>
                </div>

                {/* Overdue Payments Alert */}
                {overdue_payments.length > 0 && (
                    <Card className="border-red-200 bg-red-50">
                        <CardHeader className="pb-3">
                            <CardTitle className="text-red-800 flex items-center">
                                <span className="mr-2">⚠️</span>
                                Tunggakan IPL ({overdue_payments.length} warga)
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="grid gap-2 max-h-40 overflow-y-auto">
                                {overdue_payments.slice(0, 5).map((payment) => (
                                    <div key={payment.id} className="flex items-center justify-between py-1 text-sm">
                                        <span className="text-red-700">
                                            {payment.resident.nama_warga} ({payment.resident.blok_nomor_rumah})
                                        </span>
                                        <span className="text-red-600">
                                            {payment.formatted_month} {payment.tahun_periode}
                                        </span>
                                    </div>
                                ))}
                                {overdue_payments.length > 5 && (
                                    <p className="text-red-600 text-xs">
                                        dan {overdue_payments.length - 5} warga lainnya...
                                    </p>
                                )}
                            </div>
                        </CardContent>
                    </Card>
                )}

                {/* Filters */}
                <Card>
                    <CardContent className="p-4">
                        <div className="grid grid-cols-1 md:grid-cols-5 gap-4">
                            {/* Search */}
                            <form onSubmit={handleSearch} className="md:col-span-2">
                                <div className="flex space-x-2">
                                    <Input
                                        type="text"
                                        placeholder="Cari nama warga atau blok..."
                                        value={searchTerm}
                                        onChange={(e) => setSearchTerm(e.target.value)}
                                    />
                                    <Button type="submit" variant="outline">
                                        🔍
                                    </Button>
                                </div>
                            </form>

                            {/* Year Filter */}
                            <Select
                                value={filters.year || ''}
                                onValueChange={(value) => handleFilter('year', value)}
                            >
                                <SelectTrigger>
                                    <SelectValue placeholder="Pilih Tahun" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="">Semua Tahun</SelectItem>
                                    {years.map((year) => (
                                        <SelectItem key={year} value={year.toString()}>
                                            {year}
                                        </SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>

                            {/* Month Filter */}
                            <Select
                                value={filters.month || ''}
                                onValueChange={(value) => handleFilter('month', value)}
                            >
                                <SelectTrigger>
                                    <SelectValue placeholder="Pilih Bulan" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="">Semua Bulan</SelectItem>
                                    {Object.entries(months).map(([key, label]) => (
                                        <SelectItem key={key} value={key}>
                                            {label}
                                        </SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>

                            {/* Status Filter */}
                            <Select
                                value={filters.status || ''}
                                onValueChange={(value) => handleFilter('status', value)}
                            >
                                <SelectTrigger>
                                    <SelectValue placeholder="Pilih Status" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="">Semua Status</SelectItem>
                                    <SelectItem value="paid">Lunas</SelectItem>
                                    <SelectItem value="unpaid">Belum Bayar</SelectItem>
                                    <SelectItem value="exempt">Bebas IPL</SelectItem>
                                </SelectContent>
                            </Select>
                        </div>
                    </CardContent>
                </Card>

                {/* Data Table */}
                <Card>
                    <CardHeader>
                        <CardTitle>
                            Data Pembayaran IPL ({ipl_payments.meta.total} total)
                        </CardTitle>
                    </CardHeader>
                    <CardContent className="p-0">
                        <div className="overflow-x-auto">
                            <table className="w-full">
                                <thead className="bg-gray-50">
                                    <tr>
                                        <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            No.
                                        </th>
                                        <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Warga
                                        </th>
                                        <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Periode
                                        </th>
                                        <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nominal
                                        </th>
                                        <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody className="bg-white divide-y divide-gray-200">
                                    {ipl_payments.data.map((payment) => (
                                        <tr key={payment.id} className="hover:bg-gray-50">
                                            <td className="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {payment.nomor}
                                            </td>
                                            <td className="px-4 py-4 whitespace-nowrap">
                                                <div>
                                                    <div className="text-sm font-medium text-gray-900">
                                                        {payment.resident.nama_warga}
                                                    </div>
                                                    <div className="text-sm text-gray-500">
                                                        {payment.resident.blok_nomor_rumah}
                                                    </div>
                                                </div>
                                            </td>
                                            <td className="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {payment.formatted_month} {payment.tahun_periode}
                                            </td>
                                            <td className="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {payment.formatted_amount}
                                            </td>
                                            <td className="px-4 py-4 whitespace-nowrap">
                                                {getStatusBadge(payment.status_pembayaran, payment.rumah_kosong)}
                                            </td>
                                            <td className="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                                <div className="flex space-x-2">
                                                    <Link href={route('ipl.show', payment.id)}>
                                                        <Button size="sm" variant="outline">
                                                            Lihat
                                                        </Button>
                                                    </Link>
                                                    <Link href={route('ipl.edit', payment.id)}>
                                                        <Button size="sm" variant="outline">
                                                            Edit
                                                        </Button>
                                                    </Link>
                                                </div>
                                            </td>
                                        </tr>
                                    ))}
                                    {ipl_payments.data.length === 0 && (
                                        <tr>
                                            <td colSpan={6} className="px-4 py-8 text-center text-gray-500">
                                                Tidak ada data IPL yang ditemukan
                                            </td>
                                        </tr>
                                    )}
                                </tbody>
                            </table>
                        </div>
                        
                        {/* Pagination */}
                        {ipl_payments.links && (
                            <div className="px-4 py-3 border-t">
                                <div className="flex justify-between items-center">
                                    <div className="text-sm text-gray-500">
                                        Menampilkan {ipl_payments.meta.from || 0} - {ipl_payments.meta.to || 0} dari {ipl_payments.meta.total} data
                                    </div>
                                    <div className="flex space-x-1">
                                        {ipl_payments.links.map((link: PaginationLink, index: number) => (
                                            <button
                                                key={index}
                                                onClick={() => {
                                                    if (link.url) {
                                                        router.get(link.url, {}, { preserveState: true, preserveScroll: true });
                                                    }
                                                }}
                                                disabled={!link.url}
                                                className={`px-3 py-1 text-sm border rounded ${
                                                    link.active 
                                                        ? 'bg-blue-600 text-white border-blue-600' 
                                                        : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'
                                                } ${!link.url ? 'opacity-50 cursor-not-allowed' : ''}`}
                                                dangerouslySetInnerHTML={{ __html: link.label }}
                                            />
                                        ))}
                                    </div>
                                </div>
                            </div>
                        )}
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}