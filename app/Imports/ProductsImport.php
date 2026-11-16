<?php
namespace App\Imports;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class ProductsImport implements ToModel, WithHeadingRow
{
    

    public function model(array $row)
    {
        $name = $row['name'] ?? null;
        if (empty($name)) {
            return null;
        }

       $imagePath =null;
        if (!empty($row['image'])){
            try{
                $imageUrl = trim($row['image']);
                $contents = Http::timeout(10)->get($imageUrl)->body();

                $filename = 'products/' . Str::slug($row['name']) . '-' . time() . '.jpg';

                Storage::disk('public')->put($filename,$contents);
                $imagePath = $filename;
            } catch (\Exception $e) {
                $imagePath = null;
            }
        }

       return new Product([
            'name'        => $row['name'] ?? null,
            'category_id' => $row['category_id'] ?? 1,
            'price'       => $row['price'] ?? 0,
            'stock'       => $row['stock'] ?? 10,
            'image'       => $imagePath,
            'description' => $row['description'] ?? null,       
        ]);
    }
}