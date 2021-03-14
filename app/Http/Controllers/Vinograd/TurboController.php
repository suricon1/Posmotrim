<?php

namespace App\Http\Controllers\Vinograd;

use App\Http\Controllers\Controller;
use App\Models\Vinograd\Category;
use App\Repositories\ProductRepository;

class TurboController extends Controller
{
    public function turbo(ProductRepository $productRepository)
    {
        $categorys = Category::active()->get();
        $products = $productRepository->getAllProducts();

        $turbo = '<?xml version="1.0" encoding="UTF-8"?><yml_catalog date="'.date('Y-m-d h:m').'"></yml_catalog>';
        $xmlturbo = new \SimpleXMLElement($turbo);
        $shop = $xmlturbo->addChild("shop");
        $shop->addChild('name', 'Виноград в Минске');
        $shop->addChild('company', 'Виноград в Минске');
        $shop->addChild('url', route('vinograd.home'));

        $currencies = $shop->addChild('currencies');
            $currency = $currencies->addChild('currency');
                $currency->addAttribute('id', 'BYN');
                $currency->addAttribute('rate', '1');
//            $currency = $currencies->addChild('currency');
//                $currency->addAttribute('id', 'RUR');
//                $currency->addAttribute('rate', '33');
//            $currency = $currencies->addChild('currency');
//                $currency->addAttribute('id', 'USD');
//                $currency->addAttribute('rate', '2');

            $categories_xml = $shop->addChild('categories');
            foreach ($categorys as $categori){
                $category = $categories_xml->addChild('category', $categori->name);
                $category->addAttribute('id', $categori->id);
            }
//        $shop->addChild('store', 'false');
//        $shop->addChild('pickup', 'true');
//        $shop->addChild('delivery', 'true');
//        $delivery_options = $shop->addChild('delivery-options');
//            $option = $delivery_options->addChild('option');
//            $option->addAttribute('cost', '300');
//            $option->addAttribute('days', '0');
//            $option->addAttribute('order-before', '12');
        $offers = $shop->addChild('offers');

        foreach ($products as $product) {
            foreach ($product->modifications as $modification) {
                $offer = $offers->addChild('offer');
                    $offer->addAttribute('id', $modification->id);
                    //$offer->addAttribute('bid', '80');
                $offer->addChild('typePrefix', 'виноград ' . $modification->name);
                $offer->addChild('name', $product->name.' '.$modification->name);
                //$offer->addChild('model', $modification->name);
                $offer->addChild('url', route('vinograd.product', $product->slug));
                $offer->addChild('price', $modification->price);
                $offer->addChild('currencyId', 'BYN');
                $offer->addChild('categoryId', $product->category->id);
                $offer->addChild('picture', $product->getImage('400x400'));
                $offer->addChild('store', 'false');
                $offer->addChild('pickup', 'true');
                $offer->addChild('delivery', 'true');
//                $offer_delivery_options = $offer->addChild('delivery-options');
//                    $offer_option = $offer_delivery_options->addChild('option');
//                    $offer_option->addAttribute('cost', '300');
//                    $offer_option->addAttribute('days', '0');
//                    $offer_option->addAttribute('order-before', '12');

                $offer->addChild('description', '<![CDATA[' . $product->StrForTurbo($product->description) . ']]>');

                $param = $offer->addChild('param', $product->category::getRipeningName($product->ripening). ' дней');
                    $param->addAttribute('name', 'Срок созревания');
                $param = $offer->addChild('param', $product->mass . ' гр');
                    $param->addAttribute('name', 'Масса грозди');
                $param = $offer->addChild('param', $product->color);
                    $param->addAttribute('name', 'Окраска');
                $param = $offer->addChild('param', $product->flavor);
                    $param->addAttribute('name', 'Вкус');
                $param = $offer->addChild('param', $product->frost.' &#8451;');
                    $param->addAttribute('name', 'Морозоустойчивость');
                $param = $offer->addChild('param', $product->flower);
                    $param->addAttribute('name', 'Цветок');
                //$offer->addChild('sales_notes', 'Необходима предоплата.');<param name="Цвет">белый</param>
            }
        }

        return response($xmlturbo->asXML())->header('Content-Type', 'text/xml');
    }
}
