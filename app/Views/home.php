<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div>
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Transport Management System</h1>
        <p class="text-xl text-gray-600">Manage customers, products, and transactions efficiently</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200 cursor-pointer" onclick="window.location.href='<?= base_url('/customers') ?>'">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Customers</p>
                    <p class="text-3xl font-bold text-blue-600">0</p>
                </div>
                <div class="bg-blue-100 p-4 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.5 1.5H5.75A2.25 2.25 0 003.5 3.75v12.5A2.25 2.25 0 005.75 18.5h8.5a2.25 2.25 0 002.25-2.25V6.5m-11-5v5m5-5v5M3.5 11.5h13" stroke="currentColor" stroke-width="1.5" fill="none"/>
                    </svg>
                </div>
            </div>
            <p class="text-gray-500 text-xs mt-4">Manage customer data</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200 cursor-pointer" onclick="window.location.href='<?= base_url('/products') ?>'">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Products</p>
                    <p class="text-3xl font-bold text-green-600">0</p>
                </div>
                <div class="bg-green-100 p-4 rounded-lg">
                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.82.4l2.7 3.6a1 1 0 01-.82 1.6H3a1 1 0 000 2h15v2a3 3 0 01-3 3H6a3 3 0 01-3-3V6zm11 1H4v3h10V7z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <p class="text-gray-500 text-xs mt-4">Manage product inventory</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200 cursor-pointer" onclick="window.location.href='<?= base_url('/transactions') ?>'">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Transactions</p>
                    <p class="text-3xl font-bold text-purple-600">0</p>
                </div>
                <div class="bg-purple-100 p-4 rounded-lg">
                    <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"/>
                        <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 011 1v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6zm11-4a1 1 0 10-2 0 1 1 0 002 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <p class="text-gray-500 text-xs mt-4">Manage invoices</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-md p-6 text-white">
            <h3 class="text-lg font-bold mb-2">Create New Customer</h3>
            <p class="text-blue-100 mb-4">Add a new customer</p>
            <a href="<?= base_url('/customers/create') ?>" class="inline-block bg-white text-blue-600 font-bold py-2 px-4 rounded-lg hover:bg-blue-50 transition duration-200">
                Get Started →
            </a>
        </div>

        <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-lg shadow-md p-6 text-white">
            <h3 class="text-lg font-bold mb-2">Add New Product</h3>
            <p class="text-green-100 mb-4">Create a new product to inventory</p>
            <a href="<?= base_url('/products/create') ?>" class="inline-block bg-white text-green-600 font-bold py-2 px-4 rounded-lg hover:bg-green-50 transition duration-200">
                Get Started →
            </a>
        </div>

        <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-lg shadow-md p-6 text-white">
            <h3 class="text-lg font-bold mb-2">Create New Invoice</h3>
            <p class="text-purple-100 mb-4">Generate a new invoice for transactions</p>
            <a href="<?= base_url('/transactions/create') ?>" class="inline-block bg-white text-purple-600 font-bold py-2 px-4 rounded-lg hover:bg-purple-50 transition duration-200">
                Get Started →
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
