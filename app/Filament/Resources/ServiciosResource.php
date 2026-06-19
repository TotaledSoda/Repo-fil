<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiciosResource\Pages;
use App\Models\Servicios;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ServiciosResource extends Resource
{
    protected static ?string $model = Servicios::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';public function index() {
    return view('welcome', [
        'servicios' => \App\Models\Servicios::all(),
        'heroSlides' => \App\Models\HeroSlide::orderBy('order', 'asc')->get()
    ]);
}

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->label('Título del Servicio'),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->label('Descripción'),
                Forms\Components\TextInput::make('icon')
                    ->required()
                    ->label('Nombre del ícono'),
                Forms\Components\TagsInput::make('technologies')
                    ->label('Tecnologías')
                    ->separator(','),
                Forms\Components\FileUpload::make('image_path')
                    ->label('Imagen del Servicio')
                    ->image()
                    ->directory('servicios') // Las guardará en storage/app/public/servicios
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Servicio'),
                Tables\Columns\TextColumn::make('icon')->label('Ícono'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServicios::route('/'),
            'create' => Pages\CreateServicios::route('/create'),
            'edit' => Pages\EditServicios::route('/{record}/edit'), // Cambio clave aquí
        ];
    }
}