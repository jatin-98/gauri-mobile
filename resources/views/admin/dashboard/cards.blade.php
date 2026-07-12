<div class="col-sm-6 col-xl-3 col-lg-6">
    <div class="card o-hidden">
        <div class="bg-primary b-r-4 card-body">
            <div class="media static-top-widget">
                <div class="align-self-center text-center"><i data-feather="database"></i></div>
                <div class="media-body"><span class="m-0">Earnings</span>
                    <h4 class="mb-0 counter">₹{{ (int) $earnings}}</h4><i class="icon-bg" data-feather="database"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-6 col-xl-3 col-lg-6">
    <div class="card o-hidden">
        <div class="bg-secondary b-r-4 card-body">
            <div class="media static-top-widget">
                <div class="align-self-center text-center"><i data-feather="shopping-bag"></i></div>
                <div class="media-body"><span class="m-0">Products</span>
                    <h4 class="mb-0 counter">{{$productCount}}</h4><i class="icon-bg" data-feather="shopping-bag"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-6 col-xl-3 col-lg-6">
    <div class="card o-hidden">
        <div class="bg-primary b-r-4 card-body">
            <div class="media static-top-widget">
                <div class="align-self-center text-center"><i data-feather="truck"></i></div>
                <div class="media-body"><span class="m-0">Available Stock</span>
                    <h4 class="mb-0 counter">{{$stockCount}}</h4><i class="icon-bg" data-feather="truck"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-6 col-xl-3 col-lg-6">
    <div class="card o-hidden">
        <div class="bg-primary b-r-4 card-body">
            <div class="media static-top-widget">
                <div class="align-self-center text-center"><i data-feather="award"></i></div>
                <div class="media-body"><span class="m-0">Best Selling Item</span>
                    <h4 class="mb-0 counter">{{$bestSellingProductsByQuantity[0]->product_name ?? "N/A"}}</h4><i class="icon-bg" data-feather="award"></i>
                </div>
            </div>
        </div>
    </div>
</div>