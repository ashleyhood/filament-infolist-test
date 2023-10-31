<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('first_name'),
                TextColumn::make('last_name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'view' => Pages\ViewClient::route('/{record}'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                RepeatableEntry::make('openReferralAppointments')->schema([
                    TextEntry::make('id'),
                    TextEntry::make('start_at'),
                    TextEntry::make('status'),

                    RepeatableEntry::make('contactLog.notes')->schema([
                        TextEntry::make('id'),
                        TextEntry::make('name'),
                        TextEntry::make('body'),
                    ]),

                    Infolists\Components\Section::make('Contact Log - Notes')
                        ->description('When the RepeatableEntry is wrapped in a Section/Grid/Group the notes are always the same.')
                        ->schema([
                            RepeatableEntry::make('contactLog.notes')->schema([
                                TextEntry::make('id'),
                                TextEntry::make('name'),
                                TextEntry::make('body'),
                            ]),
                    ]),
                ])->columnSpanFull(),
            ]);
    }
}
