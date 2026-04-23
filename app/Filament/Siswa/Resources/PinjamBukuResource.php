<?php

namespace App\Filament\Siswa\Resources;

use App\Filament\Siswa\Resources\PinjamBukuResource\Pages;
use App\Models\Buku;
use App\Models\Peminjaman;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class PinjamBukuResource extends Resource
{
    protected static ?string $model = Buku::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Pinjam Buku';

    protected static ?string $modelLabel = 'Buku';

    protected static ?string $pluralModelLabel = 'Daftar Buku';

    protected static ?int $navigationSort = 1;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\ImageColumn::make('cover')
                    ->label('Cover')
                    ->circular()
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=B&background=10b981&color=fff'),
                Columns\TextColumn::make('judul')
                    ->label('Judul Buku')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Columns\TextColumn::make('pengarang')
                    ->label('Pengarang')
                    ->searchable()
                    ->sortable(),
                Columns\TextColumn::make('penerbit')
                    ->label('Penerbit')
                    ->toggleable(),
                Columns\TextColumn::make('tahun_terbit')
                    ->label('Tahun')
                    ->sortable(),
                Columns\TextColumn::make('stok')
                    ->label('Stok Tersedia')
                    ->sortable()
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state === 0 => 'danger',
                        $state <= 2 => 'warning',
                        default => 'success',
                    }),
            ])
            ->filters([])
            ->actions([
                Action::make('pinjam')
                    ->label('Pinjam')
                    ->icon('heroicon-o-hand-raised')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Peminjaman')
                    ->modalDescription(fn (Buku $record) => "Apakah Anda ingin meminjam buku \"{$record->judul}\"? Batas pengembalian 7 hari.")
                    ->visible(fn (Buku $record): bool => $record->stok > 0)
                    ->action(function (Buku $record) {
                        $user = auth()->user();

                        $existing = Peminjaman::where('user_id', $user->id)
                            ->where('buku_id', $record->id)
                            ->whereIn('status', ['dipinjam', 'menunggu_pembayaran'])
                            ->exists();

                        if ($existing) {
                            Notification::make()
                                ->title('Gagal')
                                ->body('Anda sudah meminjam buku ini dan belum mengembalikannya/melunasi dendanya.')
                                ->danger()
                                ->send();
                            return;
                        }

                        $unpaidFines = Peminjaman::where('user_id', $user->id)
                            ->whereIn('status', ['dipinjam', 'menunggu_pembayaran'])
                            ->get()
                            ->sum('denda_sekarang');

                        if ($unpaidFines > 0) {
                            Notification::make()
                                ->title('Akses Ditolak')
                                ->body('Anda tidak dapat meminjam buku baru karena memiliki tanggungan denda sebesar Rp ' . number_format($unpaidFines, 0, ',', '.') . '.')
                                ->danger()
                                ->send();
                            return;
                        }

                        Peminjaman::create([
                            'user_id' => $user->id,
                            'buku_id' => $record->id,
                            'tanggal_pinjam' => now(),
                            'tanggal_kembali' => now()->addDays(7),
                            'status' => 'dipinjam',
                        ]);

                        $record->decrement('stok');

                        Notification::make()
                            ->title('Berhasil!')
                            ->body("Buku \"{$record->judul}\" berhasil dipinjam. Harap dikembalikan sebelum " . now()->addDays(7)->format('d M Y') . ".")
                            ->success()
                            ->send();
                    }),
                ViewAction::make()->label('Detail'),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPinjamBukus::route('/'),
        ];
    }
}
