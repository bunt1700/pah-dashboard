<div class="col-md-3">
    <div class="ibox">
        <div class="ibox-content product-box">
            <div class="product-imitation">
                x
            </div>
            <div class="product-desc">
                <span class="product-price">{{ $product->offer->price }}</span>
                <small class="text-muted">{{ $product->productgroup }}</small>
                <a href="#" class="product-name">{{ $product->name }}</a>
                <div class="small m-t-xs">
                    @if ($product->description)
                        {{ $product->description }}
                    @else
                        <table>
                            @foreach ($product->attributes->slice(0, 3) as $attribute)
                                <tr>
                                    <td>{{ $attribute->name }}:</td>
                                    <td>{{ (string)$attribute }}</td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
                <div class="m-t text-right">
                    <a href="ecommerce_product.html" class="btn btn-xs btn-outline">
                        Bekijken
                    </a>
                    <a href="ecommerce_product.html" class="btn btn-xs btn-outline btn-primary">
                        Bewerken <i class="fa fa-long-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>