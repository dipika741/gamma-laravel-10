<?php

if (!function_exists('build_product_route_params')) {
    /**
     * Build route parameters dynamically for a product.
     *
     * @param  object  $category
     * @param  object|null  $subcategory
     * @param  object|null  $subsubcategory
     * @param  object  $product
     * @return array
     */
    function build_product_route_params($category, $subcategory = null, $subsubcategory = null, $product)
    {
        $routeParams = ['category' => $category->slug];

        if ($subcategory) {
            $routeParams['subcategory'] = $subcategory->slug;
        }

        if ($subsubcategory) {
            $routeParams['subsubcategory'] = $subsubcategory->slug;
        }

        $routeParams['product'] = $product->slug;

        return $routeParams;
    }
}
