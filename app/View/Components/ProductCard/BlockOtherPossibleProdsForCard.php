<?php

namespace App\View\Components\ProductCard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Product;

use Illuminate\Support\Facades\DB;  // подключаем фасад DB - Построитель запросов позволяет отправлять запросы к базе, используя PHP команды
use App\Traits\FilterTrait;

class BlockOtherPossibleProdsForCard extends Component
{   

    use FilterTrait;

    public function __construct()
    {
        //
    }

    public function getOtherProductsForCard() {

        $prodUrlSemantic = $this->getSlug();    
        $product = Product::where('prod_url_semantic', $prodUrlSemantic)->first();
        
        $resultOtherProductsForCard = [];
        $resultOtherProductsForCard['href'] = false;
         
        # balls
        if($product->category_id == '3') {
            // смотрим характеристики текущего товара:
            $currentProdModel = $product->model;
            $currentProdBrandId = $product->brand_id;
            $currentProdColour = $product->colour;
            $currentProdCategoryId = $product->category_id;

            // выбираем крюки цветов, отличных от текущего:
            $sql = "SELECT DISTINCT p.category_id, p.prod_url_semantic, p.colour, p.model, i.img_main, i.img_link
            FROM products p, images i
            WHERE p.id = i.product_id AND p.category_id = $currentProdCategoryId 
            AND p.model LIKE '$currentProdModel'
            -- AND p.brand_id = $currentProdBrandId
            AND colour NOT LIKE '$currentProdColour'   
            AND i.img_main IN (1)
            ";
            //$otherProductsForCard = DB::raw($sql); -это не сработало. Просто выводит сам запрос
            
            $otherProductsForCard =  DB::table('products')
                ->select('category_id', 'prod_url_semantic', 'colour', 'model', 'img_main', 'img_link')
                ->join('images', 'images.product_id', '=', 'products.id') 
                ->where('products.category_id', '=', $currentProdCategoryId) 
                ->where('products.model', 'LIKE', $currentProdModel)
                ->where('products.colour', 'NOT LIKE', $currentProdColour)
                ->where('images.img_main', '=', '1')
                ->distinct()
                ->get();
            
            $resultOtherProductsForCard['classComponent'] = 'colour';
            $resultOtherProductsForCard['choiceComment'] = '';                  // <p>Другие возможные размеры:&nbsp;&nbsp;&nbsp;</p>
            $resultOtherProductsForCard['products'] = $otherProductsForCard;
            $resultOtherProductsForCard['href'] = true;

            return $resultOtherProductsForCard;
        }
    } 
    

    public function render(): View|Closure|string
    {
        $otherProductsForCard = $this->getOtherProductsForCard();
                
        return view('components.product-card.block-other-possible-prods-for-card', [
            'resultOtherProductsForCard' => $otherProductsForCard,
        ]);

    }
}
