<?php

namespace App\Filament\Siswa\Resources;

use App\Filament\Siswa\Resources\PeminjamanSayaResource\Pages;
use App\Models\Peminjaman;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns;
use Filament\Tables\Filters;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PeminjamanSayaResource extends Resource
{
    protected static ?string $model = Peminjaman::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Peminjaman Saya';

    protected static ?string $modelLabel = 'Peminjaman';

    protected static ?string $pluralModelLabel = 'Peminjaman Saya';

    protected static ?int $navigationSort = 2;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\TextColumn::make('buku.judul')
                    ->label('Judul Buku')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Columns\TextColumn::make('buku.pengarang')
                    ->label('Pengarang')
                    ->sortable(),
                Columns\TextColumn::make('tanggal_pinjam')
                    ->label('Tgl Pinjam')
                    ->date('d M Y')
                    ->sortable(),
                Columns\TextColumn::make('tanggal_kembali')
                    ->label('Batas Kembali')
                    ->date('d M Y')
                    ->sortable()
                    ->color(fn (Peminjaman $record): string =>
                        $record->status === 'dipinjam' && $record->tanggal_kembali->isPast()
                            ? 'danger'
                            : 'gray'
                    ),
                Columns\TextColumn::make('tanggal_dikembalikan')
                    ->label('Tgl Dikembalikan')
                    ->date('d M Y')
                    ->sortable()
                    ->placeholder('—'),
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
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'dipinjam' => 'Dipinjam',
                        'dikembalikan' => 'Dikembalikan',
                    ]),
            ])
            ->actions([
                // Pengembalian hanya boleh dilakukan oleh Admin/Petugas
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
            'index' => Pages\ListPeminjamanSayas::route('/'),
        ];
    }
}
