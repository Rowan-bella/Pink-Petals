<?php
namespace App\Exports;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ProductsExport implements FromCollection, WithHeadings, WithMapping, WithDrawings
{
    public function collection()
    {
        return Product::all();
    }

    public function headings(): array
    {
        return [
            "ID",
            "Name",
            "Category ID",
            "Price",
            "Stock",
            "Image", 
            "Description",
            "Created At",
            "Updated At"
        ];
    }

    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            $product->category_id,
            $product->price,
            $product->stock,
            '', 
            $product->description,
            $product->created_at,
            $product->updated_at,
        ];
    }

    public function drawings()
    {
        $products = Product::all();
        $drawings = [];
        $rowNumber=2;
        foreach ($products as $index => $product) {
        
            $imagePath = public_path('storage/' . $product->image);

            if ($product->image && file_exists($imagePath)) {
                $drawing = new Drawing();
                $drawing->setName('Product Image');
                $drawing->setDescription('Image');
                $drawing->setPath($imagePath);
                $drawing->setHeight(40); 
                $drawing->setCoordinates('F' . $rowNumber); 
                
                $drawings[] = $drawing;
            }
            $rowNumber++;
        }

        return $drawings;
    }
}