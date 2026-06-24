<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-900">Product Management</h2>
        <a href="<?= base_url('/products/create') ?>" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd" />
            </svg>
            Add New Product
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <form method="GET" class="flex gap-4 flex-wrap">
            <input type="text" name="search_product_code" placeholder="Search Product Code..." value="<?= esc($filters['product_code']) ?>" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            <input type="text" name="search_product_name" placeholder="Search Product Name..." value="<?= esc($filters['product_name']) ?>" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            <select name="limit" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                <option value="10" <?= $limit == 10 ? 'selected' : '' ?>>10 per page</option>
                <option value="25" <?= $limit == 25 ? 'selected' : '' ?>>25 per page</option>
                <option value="50" <?= $limit == 50 ? 'selected' : '' ?>>50 per page</option>
            </select>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">Search</button>
            <a href="<?= base_url('/products') ?>" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-lg transition duration-200">Reset</a>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <?php if (!empty($data)): ?>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b-2 border-gray-300">
                        <tr>
                            <th class="px-6 py-3 text-left text-gray-700 font-bold">Product Code</th>
                            <th class="px-6 py-3 text-left text-gray-700 font-bold">Product Name</th>
                            <th class="px-6 py-3 text-left text-gray-700 font-bold">Unit</th>
                            <th class="px-6 py-3 text-right text-gray-700 font-bold">Price</th>
                            <th class="px-6 py-3 text-center text-gray-700 font-bold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $product): ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 text-gray-900 font-medium"><?= esc($product->product_code) ?></td>
                                <td class="px-6 py-4 text-gray-900"><?= esc($product->product_name) ?></td>
                                <td class="px-6 py-4 text-gray-900"><?= esc($product->unit) ?></td>
                                <td class="px-6 py-4 text-gray-900 text-right font-semibold">IDR <?= number_format($product->price, 0, ',', '.') ?></td>
                                <td class="px-6 py-4 text-center">
                                    <a href="<?= base_url('/products/' . $product->id . '/edit') ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded transition duration-200 inline-block mr-2">Edit</a>
                                    <button onclick="confirmDelete(<?= $product->id ?>)" class="bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-3 rounded transition duration-200">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <?= $pager->links() ?>
            </div>
        <?php else: ?>
            <div class="px-6 py-12 text-center text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <p class="text-lg">No products found</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-96 shadow-xl">
        <h3 class="text-xl font-bold mb-4 text-gray-900">Confirm Delete</h3>
        <p class="text-gray-600 mb-6">Are you sure you want to delete this product? This action cannot be undone.</p>
        <div class="flex justify-end gap-3">
            <button onclick="closeDeleteModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Cancel</button>
            <form id="deleteForm" method="POST" style="display: inline;">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmDelete(productId) {
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteForm').action = '<?= base_url('/products') ?>/' + productId;
        document.getElementById('deleteForm').method = 'POST';
        
        let input = document.createElement('input');
        input.type = 'hidden';
        input.name = '_method';
        input.value = 'DELETE';
        document.getElementById('deleteForm').appendChild(input);
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>
<?= $this->endSection() ?>
