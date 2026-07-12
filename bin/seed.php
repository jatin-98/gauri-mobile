<?php



use App\Core\Application;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

// Bootstrap application to get database connection
$app = require __DIR__ . '/../bootstrap/app.php';
// App already booted by bootstrap

$faker = Factory::create();

echo "Seeding started...\n";

// Ensure foreign key checks are disabled during truncation (though we're just inserting here)
// Actually, let's just insert!

// ----------------------------------------------------------------------
// 1. Seed Products (1000)
// ----------------------------------------------------------------------
echo "Seeding Products...\n";
$productsData = [];
for ($i = 0; $i < 1000; $i++) {
    $productsData[] = [
        'product_name' => rtrim($faker->sentence(3), '.'),
        'product_description' => $faker->paragraph(2),
        'stock' => $faker->numberBetween(10, 500),
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
    ];
}
// Insert in chunks of 500 to avoid query too large errors
foreach (array_chunk($productsData, 500) as $chunk) {
    DB::table('products')->insert($chunk);
}
echo "✓ 1000 Products seeded.\n";

// ----------------------------------------------------------------------
// 2. Seed Sales (1000)
// ----------------------------------------------------------------------
echo "Seeding Sales...\n";
$salesData = [];
for ($i = 0; $i < 1000; $i++) {
    $cost = $faker->randomFloat(2, 5, 200);
    $handling = $faker->randomFloat(2, 1, 15);
    // sell_price = cost + handling + profit
    $sell = $cost + $handling + $faker->randomFloat(2, 5, 100);

    $salesData[] = [
        'product_name' => rtrim($faker->sentence(3), '.'),
        'cost_price' => $cost,
        'sell_price' => $sell,
        'handling_charges' => $handling,
        'sale_date' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
    ];
}
foreach (array_chunk($salesData, 500) as $chunk) {
    DB::table('sales')->insert($chunk);
}
echo "✓ 1000 Sales seeded.\n";

// ----------------------------------------------------------------------
// 3. Seed Invoices & Invoice Items (1000)
// ----------------------------------------------------------------------
echo "Seeding Invoices...\n";
for ($i = 0; $i < 1000; $i++) {
    $invoiceId = DB::table('invoices')->insertGetId([
        'invoice_number' => 'INV-' . strtoupper($faker->unique()->bothify('?????-#####')),
        'customer_name' => $faker->name(),
        'customer_email' => $faker->safeEmail(),
        'customer_phone' => $faker->phoneNumber(),
        'billing_address' => $faker->address(),
        'subtotal' => 0, // Will update below
        'discount' => 0,
        'total' => 0, // Will update below
        'payment_method' => $faker->randomElement(['Credit Card', 'Cash', 'PayPal', 'Bank Transfer']),
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
    ]);

    $itemsCount = $faker->numberBetween(1, 5);
    $itemsData = [];
    $subtotal = 0;

    for ($j = 0; $j < $itemsCount; $j++) {
        $price = $faker->randomFloat(2, 10, 500);
        $qty = $faker->numberBetween(1, 5);
        $total = $price * $qty;
        $subtotal += $total;

        $itemsData[] = [
            'invoice_id' => $invoiceId,
            'product_name' => rtrim($faker->sentence(3), '.'),
            'product_description' => $faker->sentence(6),
            'quantity' => $qty,
            'price' => $price,
            'total' => $total,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ];
    }

    DB::table('invoice_items')->insert($itemsData);

    $discount = $faker->randomElement([0, 0, 5, 10, 15, 20]);
    $finalTotal = $subtotal - $discount;

    // Update invoice with correct totals
    DB::table('invoices')->where('id', $invoiceId)->update([
        'subtotal' => $subtotal,
        'discount' => $discount,
        'total' => $finalTotal,
    ]);
}
echo "✓ 1000 Invoices seeded.\n";

echo "Database seeding completed successfully!\n";
