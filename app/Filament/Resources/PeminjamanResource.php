<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamanResource\Pages;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\User;
use BackedEnum;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns;
use Filament\Tables\Filters;
use Filament\Tables\Table;

class PeminjamanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    protected static ?string $navigationLabel = 'Transaksi Peminjaman';

    protected static ?string $modelLabel = 'Peminjaman';

    protected static ?string $pluralModelLabel = 'Peminjaman';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Transaksi')
                    ->description('Kelola transaksi peminjaman buku')
                    ->schema([
                        Select::make('user_id')
                            ->label('Siswa')
                            ->options(User::where('role', 'siswa')->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        Select::make('buku_id')
                            ->label('Buku')
                            ->options(Buku::pluck('judul', 'id'))
                            ->searchable()
                            ->required(),
                        DatePicker::make('tanggal_pinjam')
                            ->label('Tanggal Pinjam')
                            ->required()
                            ->default(now()),
                        DatePicker::make('tanggal_kembali')
                            ->label('Batas Pengembalian')
                            ->required()
                            ->default(now()->addDays(7)),
                        DatePicker::make('tanggal_dikembalikan')
                            ->label('Tanggal Dikembalikan')
                            ->nullable(),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'dipinjam' => 'Dipinjam',
                                'dikembalikan' => 'Dikembalikan',
                                'menunggu_pembayaran' => 'Menunggu Pembayaran',
                            ])
                            ->default('dipinjam')
                            ->required(),
                        Textarea::make('catatan')
                            ->label('Catatan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\TextColumn::make('user.name')
                    ->label('Siswa')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Columns\TextColumn::make('buku.judul')
                    ->label('Buku')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Columns\TextColumn::make('tanggal_pinjam')
                    ->label('Tgl Pinjam')
                    ->date('d M Y')
                    ->sortable(),
                Columns\TextColumn::make('tanggal_kembali')
                    ->label('Batas Kembali')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Columns\TextColumn::make('tanggal_dikembalikan')
                    ->label('Tgl Dikembalikan')
                    ->date('d M Y')
                    ->sortable()
                    ->placeholder('Belum dikembalikan')
                    ->toggleable(isToggledHiddenByDefault: true),
                Columns\TextColumn::make('denda_sekarang')
                    ->label('Denda')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->color(fn ($state) => $state > 0 ? 'danger' : 'gray')
                    ->sortable(),
                Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'dipinjam' => 'warning',
                        'dikembalikan' => 'success',
                        'menunggu_pembayaran' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'menunggu_pembayaran' => 'Menunggu Pelunasan',
                        default => ucfirst($state),
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'dipinjam' => 'Dipinjam',
                        'dikembalikan' => 'Dikembalikan',
                        'menunggu_pembayaran' => 'Menunggu Pembayaran',
                    ]),
            ])
            ->actions([
                Actions\ActionGroup::make([
                    Action::make('lunaskan')
                        ->label('Lunaskan Denda')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Konfirmasi Pelunasan')
                        ->modalDescription(fn (Peminjaman $record) => "Siswa memiliki denda Rp " . number_format($record->denda, 0, ',', '.') . ". Apakah uang denda sudah Anda terima?")
                        ->visible(fn (Peminjaman $record): bool => $record->status === 'menunggu_pembayaran')
                        ->action(function (Peminjaman $record) {
                            $record->update([
                                'status' => 'dikembalikan',
                            ]);
                        }),
                    Action::make('kembalikan')
                        ->label('Kembalikan')
                        ->icon('heroicon-o-arrow-uturn-left')
                        ->color('success')
                        ->form(function (Peminjaman $record) {
                            if ($record->denda_sekarang > 0) {
                                return [
                                    \Filament\Forms\Components\Checkbox::make('lunas')
                                        ->label("Denda sebesar Rp " . number_format($record->denda_sekarang, 0, ',', '.') . " telah lunas dibayar.")
                                        ->required()
                                        ->accepted(),
                                ];
                            }
                            return [];
                        })
                        ->requiresConfirmation()
                        ->modalHeading('Konfirmasi Pengembalian')
                        ->modalDescription(fn (Peminjaman $record) => $record->denda_sekarang > 0 
                            ? "Buku ini terlambat. Silakan centang kotak lunas di bawah ini sebelum mengembalikan buku."
                            : "Apakah Anda yakin buku ini sudah dikembalikan?")
                        ->visible(fn (Peminjaman $record): bool => $record->status === 'dipinjam')
                        ->action(function (Peminjaman $record) {
                            $record->update([
                                'status' => 'dikembalikan',
                                'tanggal_dikembalikan' => now(),
                                'denda' => $record->denda_sekarang,
                            ]);
                            $record->buku->increment('stok');
                        }),
                    Actions\EditAction::make(),
                    Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeminjamans::route('/'),
            'create' => Pages\CreatePeminjaman::route('/create'),
            'edit' => Pages\EditPeminjaman::route('/{record}/edit'),
        ];
    }
}
