<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BukuResource\Pages;
use App\Models\Buku;
use BackedEnum;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns;
use Filament\Tables\Table;

class BukuResource extends Resource
{
    protected static ?string $model = Buku::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Data Buku';

    protected static ?string $modelLabel = 'Buku';

    protected static ?string $pluralModelLabel = 'Buku';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Buku')
                    ->description('Lengkapi data buku yang akan ditambahkan')
                    ->schema([
                        TextInput::make('judul')
                            ->label('Judul Buku')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('pengarang')
                            ->label('Pengarang')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('penerbit')
                            ->label('Penerbit')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('tahun_terbit')
                            ->label('Tahun Terbit')
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(date('Y')),
                        TextInput::make('isbn')
                            ->label('ISBN')
                            ->maxLength(255),
                        TextInput::make('stok')
                            ->label('Stok')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->minValue(0),
                        FileUpload::make('cover')
                            ->label('Cover Buku')
                            ->image()
                            ->directory('covers')
                            ->columnSpanFull(),
                        Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\ImageColumn::make('cover')
                    ->label('Cover')
                    ->circular(),
                Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Columns\TextColumn::make('pengarang')
                    ->label('Pengarang')
                    ->searchable()
                    ->sortable(),
                Columns\TextColumn::make('penerbit')
                    ->label('Penerbit')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Columns\TextColumn::make('tahun_terbit')
                    ->label('Tahun')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Columns\TextColumn::make('isbn')
                    ->label('ISBN')
                    ->toggleable(isToggledHiddenByDefault: true),
                Columns\TextColumn::make('stok')
                    ->label('Stok')
                    ->sortable()
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state === 0 => 'danger',
                        $state <= 2 => 'warning',
                        default => 'success',
                    }),
                Columns\TextColumn::make('created_at')
                    ->label('Ditambahkan')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Actions\ActionGroup::make([
                    Actions\ViewAction::make(),
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
            'index' => Pages\ListBukus::route('/'),
            'create' => Pages\CreateBuku::route('/create'),
            'edit' => Pages\EditBuku::route('/{record}/edit'),
        ];
    }
}
