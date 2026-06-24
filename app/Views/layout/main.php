<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Transport Management' ?></title>
    <link rel="stylesheet" href="<?= base_url('src/output.css') ?>">
</head>
<body class="bg-gray-50">
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-white">Transport Management</h1>
                </div>
                <div class="flex space-x-6">
                    <a href="<?= base_url('/') ?>" class="text-gray-200 hover:text-white transition duration-200">Home</a>
                    <a href="<?= base_url('/customers') ?>" class="text-gray-200 hover:text-white transition duration-200">Customers</a>
                    <a href="<?= base_url('/products') ?>" class="text-gray-200 hover:text-white transition duration-200">Products</a>
                    <a href="<?= base_url('/transactions') ?>" class="text-gray-200 hover:text-white transition duration-200">Transactions</a>
                    <a href="<?= base_url('/logout') ?>" class="text-red-500 font-bold hover:text-white transition duration-200">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg shadow-md flex items-center justify-between animate-fade-in" id="successAlert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span><?= session()->getFlashdata('success') ?></span>
                </div>
                <button onclick="document.getElementById('successAlert').remove()" class="text-green-700 hover:text-green-900">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg shadow-md flex items-center justify-between animate-fade-in" id="errorAlert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <span><?= session()->getFlashdata('error') ?></span>
                </div>
                <button onclick="document.getElementById('errorAlert').remove()" class="text-red-700 hover:text-red-900">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        <?php endif; ?>

        <?php if (isset($errors) && is_array($errors)): ?>
            <div class="mb-4 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-lg shadow-md">
                <h3 class="font-bold mb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    Validation Errors
                </h3>
                <ul class="list-disc list-inside">
                    <?php foreach ($errors as $field => $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </main>

    <footer class="bg-gray-800 text-gray-200 py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2026 Transport Management System. All rights reserved.</p>
        </div>
    </footer>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.getElementById('successAlert');
            const errorAlert = document.getElementById('errorAlert');
            
            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.transition = 'opacity 0.3s ease-out';
                    successAlert.style.opacity = '0';
                    setTimeout(() => successAlert.remove(), 300);
                }, 5000);
            }
            
            if (errorAlert) {
                setTimeout(() => {
                    errorAlert.style.transition = 'opacity 0.3s ease-out';
                    errorAlert.style.opacity = '0';
                    setTimeout(() => errorAlert.remove(), 300);
                }, 5000);
            }
        });
    </script>
</body>
</html>
