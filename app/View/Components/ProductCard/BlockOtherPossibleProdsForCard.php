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

        ############################################################################
        #  Для формирования карточки товара определяем критерии включения в card:  #
        #                                                                          #
        # 1) ищем товары для попадания в карточку (д.б одинаковыми след. поля):    #
        # category_id, brand_id, model, marka (может чего-то не быть marka or      #
        # model), в таблице products. По этим критериям ищем id этих товаров       #
        #                                                                          #
        # 2) По полученным id получаем список этих товаров (кроме id образца) и    #
        # запрашиваем их св-ва (т.е. сюда НЕ должен попасть id оригинала товара!)  #
        #                                                                          #
        # 3) пербираем циклом полученный массив и смотрим сразу пару свойств       #
        #    (длину рукоятки и хук)                                                #
        # 4) если св-во отличное от оригинала - выводим в его виде ссылки на товар #
        #    (по id, запрос выше) если отличаются длины рукояток и/или хуки        #
        # В результате формируется карточка товара, запрошенная пользователем      #
        ############################################################################ 


        $prodUrlSemantic = $this->getSlug();    
        $product = Product::where('prod_url_semantic', $prodUrlSemantic)->first();
        
        $productId = $product->id;
        $resultOtherProductsForCard = [];
        $resultOtherProductsForCard['href'] = false;

        // для сравнения одинаковых свойств и запросе товаров в карточку данного товара - эти поля должны быть одинаковыми для товаров, которые попадут в карточку...
        $targetProductCategoryId = $product->category_id;
        $targetProductBrand      = $product->brand_id;
        $targetProductModel      = $product->model;
        $targetProductMarka      = $product->marka;
        
        # sticks dd($product);
        if($product->category_id == '1') {
            
            // сначала смотрим хват:
            $currentProductPropHookTitle = $currentProductPropHookValue = '';
            foreach($product->properties as $property) {
                if(($property->prop_title == 'hook')) {
                    $currentProductPropHookTitle = 'hook';
                    $currentProductPropHookValue = $property->prop_value_view;
                }
            }

            // смотрим отличные характеристики текущего товара:
            $currentProductSizeTitle = $product->size->size_title; // shaft_length
            $currentProductSizeValue = $product->size->size_value; // 55

/*  Запрос, который я писал до изучения Laravel:
            $possibleHookForProductCard = "SELECT DISTINCT p.id, p.prod_url_semantic, props.prop_title, props.prop_value, props.prop_value_view, s.size_title, s.size_value from products p
                LEFT JOIN sizes s ON p.size_id = s.id
                LEFT JOIN prod_prop as pp ON pp.product_id = p.id
                LEFT JOIN properties as props ON pp.property_id = props.id
                    WHERE p.category_id = '$targetProductCategoryId' AND p.brand_id = $targetProductBrand
                        AND p.model LIKE '$targetProductModel' AND p.marka LIKE '$targetProductMarka' 
                        AND props.prop_title = 'hook' AND props.prop_value_view != '$propHook[prop_value_view]'  
                        AND s.size_title LIKE 'shaft_length' AND s.size_value = '$currentProductSize'
                        AND p.id != '$targetProductId'
            ";
            $resultpossibleHookForProductCard = $this->findOne($possibleHookForProductCard);
            $product['resultpossibleHookForProductCard'] = $resultpossibleHookForProductCard;
*/
/*  Вариант 2, на Laravel: неудобно, наверное, будет, потому что, если много свойств и у товара - это будет массив, который нужно будет перебирать... в данном случае мне нужно только одно конкретное свойство
            $possibleHookForProductCard = Product::with(['size', 'properties'])
                ->where([
                    ['category_id', '=', $targetProductCategoryId],
                    ['brand_id', '=', $targetProductBrand],
                    ['model', 'like', $targetProductModel],
                    ['marka', 'like', $targetProductMarka],
                ])
                ->whereHas('size', function($query) use ($currentProductSizeValue) {
                    $query->where('size_title', 'like', 'shaft_length')
                          ->where('size_value', '=', $currentProductSizeValue);
                })
                ->whereHas('properties', function($query) use ($currentProductPropHookValue) {
                    $query->where('prop_title', 'like', 'hook')
                          ->where('prop_value_view', '!=', $currentProductPropHookValue);
                })
                ->where('id', '!=', $productId)
                ->distinct()         
            ->first();
            $product['resultpossibleHookForProductCard'] = $possibleHookForProductCard;
            dd($possibleHookForProductCard);
*/
            // Вариант 3:
            $possibleHookForProductCard = Product::select('products.id', 'products.prod_url_semantic')
                ->join('sizes', 'products.size_id', '=', 'sizes.id')
                ->join('product_property', 'products.id', '=', 'product_property.product_id')
                ->join('properties', 'product_property.property_id', '=', 'properties.id')
                ->addSelect([
                    'properties.prop_title',
                    'properties.prop_value',
                    'properties.prop_value_view',
                    'sizes.size_title',
                    'sizes.size_value'
                ])
                ->where('products.category_id', $targetProductCategoryId)
                ->where('products.brand_id', $targetProductBrand)
                ->where('products.model', 'like', '%' . $targetProductModel . '%')
                ->where('products.marka', 'like', '%' . $targetProductMarka . '%')
                ->where('sizes.size_title', 'like', 'shaft_length')
                ->where('sizes.size_value', $currentProductSizeValue)
                ->where('properties.prop_title', 'like', 'hook')
                ->where('properties.prop_value_view', '!=', $currentProductPropHookValue)
                ->where('products.id', '!=', $productId)
                ->distinct()
            ->first();
            
            // проверяем есть ли в продаже клюшки такой же модели, но с другой длиной рукоятки:
            $possibleShaftLengthArr = [];
            $resultpossibleShaftLengthForProductCard = Product::select('sizes.size_value')
                ->leftJoin('sizes', 'products.size_id', '=', 'sizes.id')
                ->where([
                    ['products.category_id', $targetProductCategoryId],
                    ['products.brand_id', $targetProductBrand],
                    ['products.model', 'like', '%' . $targetProductModel . '%'],
                    ['products.marka', 'like', '%' . $targetProductMarka . '%']
                ])
                ->distinct()
                ->get()
                ->pluck('size_value')
                ->toArray();
            
            foreach ($resultpossibleShaftLengthForProductCard as $possibleShaftLengthForProductCard) {
                $row = [];
                $classCurrent = "";
                $currentProductSize = $possibleShaftLengthForProductCard;
                
                $resNewItem = Product::select('p.id', 'p.prod_url_semantic', 'props.prop_title', 'props.prop_value', 'props.prop_value_view', 's.size_title', 's.size_value')
                    ->from('products as p')
                    ->leftJoin('sizes as s', 'p.size_id', '=', 's.id')
                    ->leftJoin('product_property as pp', 'pp.product_id', '=', 'p.id')
                    ->leftJoin('properties as props', 'pp.property_id', '=', 'props.id')
                    ->where([
                        ['p.category_id', $targetProductCategoryId],
                        ['p.brand_id', $targetProductBrand],
                        ['p.model', 'like', '%' . $targetProductModel . '%'],
                        ['p.marka', 'like', '%' . $targetProductMarka . '%'],
                        ['props.prop_title', 'hook'],
                        ['props.prop_value_view', $currentProductPropHookValue],
                        ['s.size_title', 'like', 'shaft_length'],
                        ['s.size_value', $currentProductSize],
                    ])                 
                ->first();

                ($currentProductSizeValue == $possibleShaftLengthForProductCard) ? $classCurrent = 'cardStick-shaftLength__item-active' : $classCurrent = 'cardStick-shaftLength__item'; 
                
                $row['size_value'] = $possibleShaftLengthForProductCard;
                $row['prod_url_semantic'] = $resNewItem['prod_url_semantic'];
                $row['classCurrent'] = $classCurrent;
                $possibleShaftLengthArr[] = $row;
            }  
            
            $product['possibleShaftLengthForProductCard'] = $possibleShaftLengthArr;
            $product['resultpossibleHookForProductCard'] = $possibleHookForProductCard;
            $product['propHook'] = $currentProductPropHookValue;
            //dd($product);
            return $product;
        }
         
        # balls
        elseif($product->category_id == '3') {
           
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
