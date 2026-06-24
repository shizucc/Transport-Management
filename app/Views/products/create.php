<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div>
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900"><?= $title ?></h2>
    </div>

    <div class="max-w-2xl bg-white rounded-lg shadow-md p-6">
        <form method="POST" action="<?= base_url('/products' . (isset($product) ? '/' . $product->id : '')) ?>" class="space-y-6 js-validated-form" novalidate>
            <?php if (isset($product)): ?>
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="id" value="<?= $product->id ?>">
            <?php endif; ?>

            <div>
                <label for="product_code" class="block text-sm font-medium text-gray-700 mb-2">Product Code *</label>
                <input 
                    type="text" 
                    id="product_code" 
                    name="product_code" 
                    value="<?= isset($product) ? esc($product->product_code) : esc(old('product_code')) ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent <?= isset($errors['product_code']) ? 'border-red-500' : '' ?>"
                    placeholder="e.g., PROD001"
                    maxlength="20"
                    required
                >
                <?php if (isset($errors['product_code'])): ?>
                    <p class="text-red-600 text-sm mt-1"><?= $errors['product_code'] ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="product_name" class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                <input 
                    type="text" 
                    id="product_name" 
                    name="product_name" 
                    value="<?= isset($product) ? esc($product->product_name) : esc(old('product_name')) ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent <?= isset($errors['product_name']) ? 'border-red-500' : '' ?>"
                    placeholder="Enter product name"
                    minlength="3"
                    maxlength="150"
                    required
                >
                <?php if (isset($errors['product_name'])): ?>
                    <p class="text-red-600 text-sm mt-1"><?= $errors['product_name'] ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">Unit *</label>
                <input 
                    type="text" 
                    id="unit" 
                    name="unit" 
                    value="<?= isset($product) ? esc($product->unit) : esc(old('unit')) ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent <?= isset($errors['unit']) ? 'border-red-500' : '' ?>"
                    placeholder="e.g., pcs, box, kg"
                    maxlength="50"
                    required
                >
                <?php if (isset($errors['unit'])): ?>
                    <p class="text-red-600 text-sm mt-1"><?= $errors['unit'] ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price (IDR) *</label>
                <input 
                    type="number" 
                    id="price" 
                    name="price" 
                    value="<?= isset($product) ? esc($product->price) : esc(old('price')) ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent <?= isset($errors['price']) ? 'border-red-500' : '' ?>"
                    placeholder="Enter price"
                    step="0.01"
                    min="0"
                    required
                >
                <?php if (isset($errors['price'])): ?>
                    <p class="text-red-600 text-sm mt-1"><?= $errors['price'] ?></p>
                <?php endif; ?>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    <?= isset($product) ? 'Update Product' : 'Add Product' ?>
                </button>
                <a href="<?= base_url('/products') ?>" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg transition duration-200">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
