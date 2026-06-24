<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div>
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900">Create New Invoice</h2>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form method="POST" action="<?= base_url('/transactions') ?>" class="space-y-6" id="invoiceForm">
            <div class="border-b pb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Basic Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="invoice_number" class="block text-sm font-medium text-gray-700 mb-2">Invoice Number *</label>
                        <input 
                            type="text" 
                            id="invoice_number" 
                            name="invoice_number" 
                            value="<?= esc(old('invoice_number')) ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent <?= isset($errors['invoice_number']) ? 'border-red-500' : '' ?>"
                            placeholder="e.g., INV-001"
                            required
                        >
                        <?php if (isset($errors['invoice_number'])): ?>
                            <p class="text-red-600 text-sm mt-1"><?= $errors['invoice_number'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="invoice_date" class="block text-sm font-medium text-gray-700 mb-2">Invoice Date *</label>
                        <input 
                            type="date" 
                            id="invoice_date" 
                            name="invoice_date" 
                            value="<?= esc(old('invoice_date', date('Y-m-d'))) ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent <?= isset($errors['invoice_date']) ? 'border-red-500' : '' ?>"
                            required
                        >
                        <?php if (isset($errors['invoice_date'])): ?>
                            <p class="text-red-600 text-sm mt-1"><?= $errors['invoice_date'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-2">Customer *</label>
                        <select 
                            id="customer_id" 
                            name="customer_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent <?= isset($errors['customer_id']) ? 'border-red-500' : '' ?>"
                            required
                            onchange="updateCustomerInfo()"
                        >
                            <option value="">-- Select Customer --</option>
                            <?php foreach ($customers as $customer): ?>
                                <option value="<?= $customer->id ?>" <?= old('customer_id') == $customer->id ? 'selected' : '' ?>>
                                    <?= esc($customer->company_name) ?> - <?= esc($customer->contact_person) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['customer_id'])): ?>
                            <p class="text-red-600 text-sm mt-1"><?= $errors['customer_id'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="pic_name" class="block text-sm font-medium text-gray-700 mb-2">PIC Name *</label>
                        <input 
                            type="text" 
                            id="pic_name" 
                            name="pic_name" 
                            value="<?= esc(old('pic_name')) ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent <?= isset($errors['pic_name']) ? 'border-red-500' : '' ?>"
                            placeholder="Person In Charge name"
                            required
                        >
                        <?php if (isset($errors['pic_name'])): ?>
                            <p class="text-red-600 text-sm mt-1"><?= $errors['pic_name'] ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="border-b pb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Items</h3>
                    <button type="button" onclick="addItemRow()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-1 px-3 rounded transition duration-200">
                        + Add Item
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left text-gray-700 font-bold">Product</th>
                                <th class="px-4 py-3 text-left text-gray-700 font-bold">Unit</th>
                                <th class="px-4 py-3 text-right text-gray-700 font-bold">Price</th>
                                <th class="px-4 py-3 text-center text-gray-700 font-bold">Qty</th>
                                <th class="px-4 py-3 text-right text-gray-700 font-bold">Subtotal</th>
                                <th class="px-4 py-3 text-center text-gray-700 font-bold">Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemsTable">
                            <tr class="border-b border-gray-200 item-row">
                                <td class="px-4 py-3">
                                    <select name="items[0][product_id]" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-500 product-select" onchange="updateRowPrice(this)">
                                        <option value="">-- Select Product --</option>
                                        <?php foreach ($products as $product): ?>
                                            <option value="<?= $product->id ?>" data-price="<?= $product->price ?>" data-unit="<?= esc($product->unit) ?>">
                                                <?= esc($product->product_code) ?> - <?= esc($product->product_name) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="hidden" name="items[0][price]" class="price-input" value="0">
                                </td>
                                <td class="px-4 py-3 product-unit text-gray-600">-</td>
                                <td class="px-4 py-3 product-price text-right font-semibold text-gray-900">0</td>
                                <td class="px-4 py-3">
                                    <input type="number" name="items[0][qty]" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-500 qty-input" min="1" value="1" onchange="updateRowTotal(this)">
                                </td>
                                <td class="px-4 py-3 text-right font-bold text-gray-900 row-total">0</td>
                                <td class="px-4 py-3 text-center">
                                    <button type="button" onclick="removeItemRow(this)" class="bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded text-sm transition duration-200">
                                        Remove
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex justify-end">
                <div class="bg-gray-100 p-6 rounded-lg w-full md:w-80">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-700">Subtotal:</span>
                        <span id="subtotal" class="font-semibold">0</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold border-t-2 border-gray-300 pt-4">
                        <span>Grand Total (IDR):</span>
                        <input type="hidden" id="grand_total" name="grand_total" value="0">
                        <span id="grandTotalDisplay">0</span>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    Create Invoice
                </button>
                <a href="<?= base_url('/transactions') ?>" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg transition duration-200">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
    const products = <?= json_encode($products) ?>;

    function addItemRow() {
        const tableBody = document.getElementById('itemsTable');
        const index = tableBody.querySelectorAll('.item-row').length;
        const newRow = document.createElement('tr');
        newRow.className = 'border-b border-gray-200 item-row';
        
        newRow.innerHTML = `
            <td class="px-4 py-3">
                <select name="items[${index}][product_id]" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-500 product-select" onchange="updateRowPrice(this)">
                    <option value="">-- Select Product --</option>
                    ${products.map(p => `<option value="${p.id}" data-price="${p.price}" data-unit="${p.unit}">${p.product_code} - ${p.product_name}</option>`).join('')}
                </select>
                <input type="hidden" name="items[${index}][price]" class="price-input" value="0">
            </td>
            <td class="px-4 py-3 product-unit text-gray-600">-</td>
            <td class="px-4 py-3 product-price text-right font-semibold text-gray-900">0</td>
            <td class="px-4 py-3">
                <input type="number" name="items[${index}][qty]" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-500 qty-input" min="1" value="1" onchange="updateRowTotal(this)">
            </td>
            <td class="px-4 py-3 text-right font-bold text-gray-900 row-total" data-value="0">0</td>
            <td class="px-4 py-3 text-center">
                <button type="button" onclick="removeItemRow(this)" class="bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded text-sm transition duration-200">
                    Remove
                </button>
            </td>
        `;
        
        tableBody.appendChild(newRow);
        reindexRows();
    }

    function removeItemRow(button) {
        const tableBody = document.getElementById('itemsTable');
        if (tableBody.querySelectorAll('.item-row').length > 1) {
            button.closest('tr').remove();
            reindexRows();
            updateGrandTotal();
        } else {
            alert('You must have at least one item');
        }
    }

    function reindexRows() {
        const rows = document.querySelectorAll('.item-row');
        rows.forEach((row, i) => {
            const select = row.querySelector('.product-select');
            const priceInput = row.querySelector('.price-input');
            const qtyInput = row.querySelector('.qty-input');

            if (select) select.name = `items[${i}][product_id]`;
            if (priceInput) priceInput.name = `items[${i}][price]`;
            if (qtyInput) qtyInput.name = `items[${i}][qty]`;
        });
    }

    function updateRowPrice(select) {
        const row = select.closest('tr');
        const selectedOption = select.options[select.selectedIndex];
        const price = parseFloat(selectedOption.dataset.price) || 0;
        const unit = selectedOption.dataset.unit || '-';
        
        const priceInput = row.querySelector('.price-input');
        if (priceInput) priceInput.value = price;

        row.querySelector('.product-unit').textContent = unit;
        row.querySelector('.product-price').textContent = price.toLocaleString('id-ID');
        
        updateRowTotal(row.querySelector('.qty-input'));
    }

    function updateRowTotal(input) {
        const row = input.closest('tr');
        const price = parseFloat(row.querySelector('.price-input').value) || 0;
        const qty = parseInt(input.value) || 0;
        const total = price * qty;

        const rowTotalEl = row.querySelector('.row-total');
        rowTotalEl.textContent = total.toLocaleString('id-ID');
        rowTotalEl.dataset.value = total;

        updateGrandTotal();
    }

    function updateGrandTotal() {
        let grandTotal = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const val = parseFloat(row.querySelector('.row-total').dataset.value) || 0;
            grandTotal += val;
        });

        document.getElementById('grandTotalDisplay').textContent = grandTotal.toLocaleString('id-ID');
        document.getElementById('grand_total').value = grandTotal;
    }

    function updateCustomerInfo() {

    }

    window.addEventListener('DOMContentLoaded', function() {
        reindexRows();
        updateGrandTotal();
    });

    document.getElementById('invoiceForm').addEventListener('submit', function(e) {
        reindexRows();
        updateGrandTotal();
    });
</script>
<?= $this->endSection() ?>
