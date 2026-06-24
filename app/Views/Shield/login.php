<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.login') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

<link rel="stylesheet" href="<?= base_url('src/output.css') ?>">

<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4">
    <div class="bg-white rounded-lg shadow-md p-8 w-full max-w-md">
        <div class="mb-8">
            <h1 class="text-3xl font-black text-purple-500 text-center"> TRANSPORT MANAGEMENT SYSTEM</h1>
        </div>

        <?php if (session('error') !== null) : ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
                <?= esc(session('error')) ?>
            </div>
        <?php elseif (session('errors') !== null) : ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
                <?php if (is_array(session('errors'))) : ?>
                    <?php foreach (session('errors') as $error) : ?>
                        <p><?= esc($error) ?></p>
                    <?php endforeach ?>
                <?php else : ?>
                    <p><?= esc(session('errors')) ?></p>
                <?php endif ?>
            </div>
        <?php endif ?>

        <?php if (session('message') !== null) : ?>
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6" role="alert">
                <?= esc(session('message')) ?>
            </div>
        <?php endif ?>

        <form action="<?= url_to('login') ?>" method="post" class="space-y-5">
            <?= csrf_field() ?>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2"><?= lang('Auth.email') ?></label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    inputmode="email" 
                    autocomplete="email" 
                    placeholder="<?= lang('Auth.email') ?>" 
                    value="<?= old('email') ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200"
                    required
                >
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2"><?= lang('Auth.password') ?></label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    inputmode="text" 
                    autocomplete="current-password" 
                    placeholder="<?= lang('Auth.password') ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200"
                    required
                >
            </div>

            <?php if (setting('Auth.sessionConfig')['allowRemembering']): ?>
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        id="remember" 
                        name="remember" 
                        class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-2 focus:ring-purple-500 cursor-pointer"
                        <?php if (old('remember')): ?> checked<?php endif ?>
                    >
                    <label for="remember" class="ml-2 text-sm font-medium text-gray-700 cursor-pointer">
                        <?= lang('Auth.rememberMe') ?>
                    </label>
                </div>
            <?php endif; ?>

            <div class="pt-4">
                <button 
                    type="submit" 
                    class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center"
                >
                    <?= lang('Auth.login') ?>
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
