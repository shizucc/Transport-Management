<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-900">Invoice Detail</h2>
        <a href="<?= base_url('/transactions') ?>"
            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg transition duration-200">Back
            to List</a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-8 max-w-4xl">
        <?php
        $header = isset($transaction['header']) ? $transaction['header'] : $transaction;
        $details = isset($transaction['details']) ? $transaction['details'] : [];
        ?>

        <div class="grid grid-cols-2 gap-8 mb-8 pb-8 border-b border-gray-200">
            <div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">PT Bhinneka Sangkuriang Transport</h3>
                <p class="text-sm text-gray-600 mb-3">Jl. Gedebage Selatan No.121A, Cisaranten Kidul, Kec. Gedebage,
                    Kota Bandung, Jawa Barat 40552</p>
                <p class="text-lg text-purple-600 font-bold"><span class="text-gray-900 font-regular">No. Faktur :
                    </span><?= esc($header->invoice_number) ?></p>
            </div>
            <div class="text-right">
                <div class="mb-1">
                    <p class="text-gray-600"><span class="font-semibold">Kepada Yth:</span></p>
                    <p class="text-gray-600"><?= esc($header->company_name ?? 'N/A') ?></p>
                </div>
                <div class="mb-1">
                    <p class="text-gray-600"><?= esc($header->address ?? 'N/A') ?></p>
                    <p class="text-gray-600"><span class="font-semibold">Up : </span><?= esc($header->pic_name) ?></p>
                </div>
            </div>
        </div>
        <div class="mb-8">
            <h4 class="font-bold text-gray-800 mb-4">Items</h4>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b-2 border-gray-300">
                        <tr>
                            <th class="px-4 py-3 text-left text-gray-700 font-bold">Product Code</th>
                            <th class="px-4 py-3 text-left text-gray-700 font-bold">Product Name</th>
                            <th class="px-4 py-3 text-left text-gray-700 font-bold">Unit</th>
                            <th class="px-4 py-3 text-right text-gray-700 font-bold">Unit Price</th>
                            <th class="px-4 py-3 text-center text-gray-700 font-bold">Quantity</th>
                            <th class="px-4 py-3 text-right text-gray-700 font-bold">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($details)): ?>
                            <?php foreach ($details as $detail): ?>
                                <tr class="border-b border-gray-200">
                                    <td class="px-4 py-3 text-gray-900"><?= esc($detail->product_code ?? 'N/A') ?></td>
                                    <td class="px-4 py-3 text-gray-900"><?= esc($detail->product_name ?? 'N/A') ?></td>
                                    <td class="px-4 py-3 text-gray-900"><?= esc($detail->unit ?? 'N/A') ?></td>
                                    <td class="px-4 py-3 text-right text-gray-900">IDR
                                        <?= number_format($detail->price ?? 0, 0, ',', '.') ?>
                                    </td>
                                    <td class="px-4 py-3 text-center text-gray-900"><?= $detail->qty ?></td>
                                    <td class="px-4 py-3 text-right font-bold text-gray-900">IDR
                                        <?= number_format(($detail->price ?? 0) * $detail->qty, 0, ',', '.') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-center text-gray-500">No items found</td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td class="px-4 py-3 text-gray-900">
                            </td>
                            <td class="px-4 py-3 text-gray-900 font-bold">
                                TOTAL
                            </td>
                            <td class="px-4 py-3 text-gray-900">
                            </td>
                            <td class="px-4 py-3 text-right text-gray-900">
                                IDR <?= number_format($transaction['totalUnitPrice'] ?? 0, 0, ',', '.') ?>
                            </td>
                            <td class="px-4 py-3 text-center text-gray-900">
                                <?= $transaction['totalQuantity'] ?>
                            </td>
                            <td class="px-4 py-3 text-right font-bold text-gray-900">IDR
                                <?= number_format($header->grand_total, 0, ',', '.') ?>
                            </td>
            </div>
            </tr>
            </tbody>
            </table>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-8 mb-8 pb-8 border-b border-gray-200">
        <div>
            <p class="text-gray-600 mb-[70px]">Purchasing:</p>
            <p class="text-gray-600"><?= auth()->user()->username ?></p>
        </div>
        <div class="text-right ">
            <p class="text-gray-600 mb-[70px]">Cirebon, <?= date("d F Y", strtotime($header->updated_at)); ?></p>
            <p class="text-gray-600"><?= esc($header->pic_name) ?></p>
        </div>
    </div>

    <div class="flex justify-between items-center pt-6 border-t border-gray-200">
        <a href="<?= base_url('/transactions') ?>" class="text-blue-600 hover:text-blue-800 font-semibold">← Back to
            Transactions</a>
        <div class="flex gap-3">
            <a href="<?= base_url('/transactions/' . $header->id . '/download') ?>"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">Download
                Invoice</a>
            <a href="<?= base_url('/transactions/' . $header->id . '/edit') ?>"
                class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded-lg transition duration-200">Edit
                Invoice</a>
            <button onclick="confirmDelete(<?= $header->id ?>)"
                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">Delete
                Invoice</button>
        </div>
    </div>
</div>
</div>

<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-96 shadow-xl">
        <h3 class="text-xl font-bold mb-4 text-gray-900">Confirm Delete</h3>
        <p class="text-gray-600 mb-6">Are you sure you want to delete this invoice? This action cannot be undone.</p>
        <div class="flex justify-end gap-3">
            <button onclick="closeDeleteModal()"
                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Cancel</button>
            <form id="deleteForm" method="POST" style="display: inline;">
                <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmDelete(transactionId) {
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteForm').action = '<?= base_url('/transactions') ?>/' + transactionId;
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