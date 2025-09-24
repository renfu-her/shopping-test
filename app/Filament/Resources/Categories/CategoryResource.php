<?php

namespace App\Filament\Resources\Categories;

use App\Filament\Resources\Categories\Pages\CreateCategory;
use App\Filament\Resources\Categories\Pages\EditCategory;
use App\Filament\Resources\Categories\Pages\ListCategories;
use App\Filament\Resources\Categories\Schemas\CategoryForm;
use App\Filament\Resources\Categories\Tables\CategoriesTable;
use App\Models\Category;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationGroup(): ?string
    {
        return 'E-commerce';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public static function form(Schema $schema): Schema
    {
        return CategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CategoriesTable::configure($table)
            ->modifyQueryUsing(function ($query) {
                // 獲取所有分類並進行階層排序
                $allCategories = $query->with('parent')->get();
                $sortedCategories = static::sortCategoriesHierarchically($allCategories);
                
                // 返回按階層排序的查詢
                return $query->whereIn('id', $sortedCategories->pluck('id'))
                    ->orderByRaw('FIELD(id, ' . $sortedCategories->pluck('id')->implode(',') . ')');
            });
    }

    private static function sortCategoriesHierarchically($categories)
    {
        $sorted = collect();
        $rootCategories = $categories->whereNull('parent_id')->sortBy('sort_order');
        
        foreach ($rootCategories as $root) {
            $sorted->push($root);
            static::addChildrenRecursively($sorted, $root, $categories);
        }
        
        return $sorted;
    }

    private static function addChildrenRecursively($sorted, $parent, $allCategories)
    {
        $children = $allCategories->where('parent_id', $parent->id)->sortBy('sort_order');
        
        foreach ($children as $child) {
            $sorted->push($child);
            static::addChildrenRecursively($sorted, $child, $allCategories);
        }
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
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }
}
