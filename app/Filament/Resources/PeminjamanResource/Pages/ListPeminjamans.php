<?php

namespace App\Filament\Resources\PeminjamanResource\Pages;

use App\Filament\Resources\PeminjamanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPeminjamans extends ListRecords
{
    protected static string $resource = PeminjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('cetak_laporan')
                ->label('Cetak Laporan PDF')
                ->icon('heroicon-o-document-text')
                ->color('danger')
                ->form([
                    \Filament\Forms\Components\DatePicker::make('tanggal_awal')
                        ->label('Dari Tanggal')
                        ->required(),
                    \Filament\Forms\Components\DatePicker::make('tanggal_akhir')
                        ->label('Sampai Tanggal')
                        ->required()
                        ->afterOrEqual('tanggal_awal'),
                ])
                ->action(function (array $data) {
                    $url = route('admin.laporan-peminjaman.pdf', [
                        'tanggal_awal' => $data['tanggal_awal'],
                        'tanggal_akhir' => $data['tanggal_akhir'],
                    ]);
                    return redirect()->to($url);
                }),
            Actions\CreateAction::make()
                ->label('Tambah Peminjaman'),
        ];
    }
}
