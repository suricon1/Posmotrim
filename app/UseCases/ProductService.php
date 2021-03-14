<?php

namespace App\UseCases;

use App\Repositories\ProductRepository;
use Cookie;

class ProductService
{
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public $comparesArray = [
        ['Название'],
        ['Фото'],
        ['Срок созревания'],
        ['Масса грозди'],
        ['Вкус'],
        ['Морозостойкость'],
        ['']
    ];

    public function getCompares()
    {
        return $this->getComparesArray($this->getComparesId());
    }

    public function addCompare($id)
    {
        $productsId = $this->getComparesId();
        if (!in_array($id, $productsId)) {
            $productsId[] = $id;
        }
        $this->setComparesId($productsId);

        return $this->getComparesArray($productsId);
    }

    public function removeCompare($id)
    {
        $productsId = $this->getComparesId();
        foreach($productsId as $key => $item){
            if ($item == $id){
                array_splice($productsId, $key, 1);
            }
        }
        $this->setComparesId($productsId);

        return $this->getComparesArray($productsId);
    }

    public function quantityCompares()
    {
        return count($this->comparesArray[0]) - 1;
    }

    private function getComparesId()
    {
        if (!$compares = json_decode(Cookie::get('compares'))) {
            $compares = [];
        }
        return $compares;
    }

    private function setComparesId($compares)
    {
        Cookie::queue('compares', json_encode($compares), 86400);
    }

    private function getComparesArray($productsId)
    {
        if ($productsId) {
            $products = $this->repository->getProductsForCompare($productsId);
            foreach ($products as $product) {
                array_push($this->comparesArray[0], '<h4>' . $product->name . '</h4>');
                array_push($this->comparesArray[1], '<a href="#" class="image"><img src="' . asset($product->getImage("100x100")) . '" width="100"></a>');
                array_push($this->comparesArray[2], $product->category::getRipeningName($product->ripening) . ' дней');
                array_push($this->comparesArray[3], $product->props['mass']);
                array_push($this->comparesArray[4], $product->props['flavor']);
                array_push($this->comparesArray[5], $product->props['frost']);
                array_push($this->comparesArray[6], '
                    <a class="btn btn-outline-success btn-sm" href="' . route('vinograd.product', ['slug' => $product->slug]) . '" role="button"><i class="fa fa-cart-plus"></i></a>
                    <button type="button" class="btn btn-outline-danger btn-sm compare" data-action="remove" data-url="' . route('vinograd.compare.delete') . '" data-product-id="' . $product->id . '"><i class="fa fa-times"></i></button>'
                );
            }
        } else {
            $this->comparesArray = [];
            $this->comparesArray[0] = ['<h3>Нечего сравнивать!</h3>'];
        }

        return $this->comparesArray;
    }
}
