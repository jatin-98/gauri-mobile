<div class="col-6">
    <div class="stats-card card border-0 shadow-sm">
        <div class="card-header card-no-border">
            <h5>Recent Sales</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Product Name</th>
                            <th scope="col">Sell Price</th>
                            <th scope="col">Cost Price</th>
                            <th scope="col">Profit %</th>
                            <th scope="col">Sale Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-center">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <strong class="d-block"><?php echo e($sale->product_name); ?></strong>
                                    </div>
                                </div>
                            </td>

                            <!-- Sell Price -->
                            <td>
                                <span class="badge bg-success-subtle text-success fs-6 fw-bold">
                                    ₹<?php echo e(number_format((int)$sale->sell_price)); ?>

                                </span>
                            </td>

                            <!-- Cost Price -->
                            <td>
                                <span class="text-muted">₹<?php echo e(number_format((int)$sale->cost_price)); ?></span>
                            </td>

                            <!-- Profit Percentage with Conditional Color -->
                            <?php
                            $profitPercent = round((($sale->sell_price - $sale->cost_price) / $sale->cost_price) * 100, 2);
                            $positiveOrNegative = $profitPercent > 0 ? "+" : "";
                            $badgeClass = $profitPercent >= 30 ? 'success' : ($profitPercent >= 15 ? 'warning' : 'danger');
                            $textClass = $profitPercent >= 15 ? 'text-white' : 'text-white';
                            ?>
                            <td>
                                <span class="text-<?php echo e($badgeClass); ?>"> <?php echo e($positiveOrNegative.$profitPercent); ?>% </span>
                            </td>
                            <!-- Sale Date -->
                            <td>
                                <div>
                                    <div class="fw-semibold"><?php echo e(\Carbon\Carbon::parse($sale->sale_date)->format('d M Y')); ?></div>
                                    <small class="text-muted"><?php echo e(\Carbon\Carbon::parse($sale->sale_date)->format('h:i A')); ?></small>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="col-6">
    <div class="card stats-card">
        <div class="card-header card-no-border">
            <h5>Best Selling Products</h5>
        </div>
        <ul class="nav nav-tabs border-tab nav-secondary mb-4" id="productTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="single-tab" data-bs-toggle="tab" href="#single" role="tab">
                    Best Selling Products By Quantity
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="multiple-tab" data-bs-toggle="tab" href="#multiple" role="tab">
                    Best Selling Products By Profit
                </a>
            </li>
        </ul>
        <div class="card-body pt-0">
            <div class="our-product">
                <div class="table-responsive">
                    <div class="tab-content" id="productTabContent">
                        <div class="tab-pane fade show active" id="single" role="tabpanel" aria-labelledby="single-tab">
                            <table class="table table-bordernone">
                                <tbody class="f-w-500">
                                    <?php $__currentLoopData = $bestSellingProductsByQuantity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <td style="padding-bottom:1rem;">
                                            <div class="media">
                                                <div class="media-body"><span><?php echo e($product->product_name); ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>₹<?php echo e((int)$product->total_profit); ?></span>
                                        </td>
                                        <td>
                                            <span><?php echo e($product->total_sales); ?> times</span>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="multiple" role="tabpanel" aria-labelledby="multiple-tab">
                            <table class="table table-bordernone">
                                <tbody class="f-w-500">
                                    <?php $__currentLoopData = $bestSellingProductsByProfit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <td style="padding-bottom:1rem;">
                                            <div class="media">
                                                <div class="media-body"><span><?php echo e($prod->product_name); ?></span> </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>₹<?php echo e((int)$prod->total_profit); ?></span>
                                        </td>
                                        <td>
                                            <span><?php echo e($prod->total_sales); ?> times</span>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\gg\views/admin/dashboard/best_products.blade.php ENDPATH**/ ?>