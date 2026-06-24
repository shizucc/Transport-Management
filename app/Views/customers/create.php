<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div>
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900"><?= $title ?></h2>
    </div>

    <div class="max-w-2xl bg-white rounded-lg shadow-md p-6">
        <form method="POST" action="<?= base_url('/customers' . (isset($customer) ? '/' . $customer->id : '')) ?>" class="space-y-6">
            <?php if (isset($customer)): ?>
                <input type="hidden" name="_method" value="PUT">
            <?php endif; ?>

            <div>
                <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">Company Name *</label>
                <input 
                    type="text" 
                    id="company_name" 
                    name="company_name" 
                    value="<?= isset($customer) ? esc($customer->company_name) : esc(old('company_name')) ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent <?= isset($errors['company_name']) ? 'border-red-500' : '' ?>"
                    placeholder="Enter company name"
                    required
                >
                <?php if (isset($errors['company_name'])): ?>
                    <p class="text-red-600 text-sm mt-1"><?= $errors['company_name'] ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="contact_person" class="block text-sm font-medium text-gray-700 mb-2">Contact Person *</label>
                <input 
                    type="text" 
                    id="contact_person" 
                    name="contact_person" 
                    value="<?= isset($customer) ? esc($customer->contact_person) : esc(old('contact_person')) ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent <?= isset($errors['contact_person']) ? 'border-red-500' : '' ?>"
                    placeholder="Enter contact person name"
                    required
                >
                <?php if (isset($errors['contact_person'])): ?>
                    <p class="text-red-600 text-sm mt-1"><?= $errors['contact_person'] ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                <textarea 
                    id="address" 
                    name="address" 
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent <?= isset($errors['address']) ? 'border-red-500' : '' ?>"
                    placeholder="Enter address"
                    required
                ><?= isset($customer) ? esc($customer->address) : esc(old('address')) ?></textarea>
                <?php if (isset($errors['address'])): ?>
                    <p class="text-red-600 text-sm mt-1"><?= $errors['address'] ?></p>
                <?php endif; ?>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    <?= isset($customer) ? 'Update Customer' : 'Add Customer' ?>
                </button>
                <a href="<?= base_url('/customers') ?>" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg transition duration-200">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
