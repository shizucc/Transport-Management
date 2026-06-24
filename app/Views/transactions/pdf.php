<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($transaction['header']->invoice_number ?? 'Invoice') ?></title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; margin: 0; padding: 24px; }
        .container { max-width: 960px; margin: 0 auto; }
        .card { background: #ffffff; padding: 32px; border: 1px solid #e5e7eb; border-radius: 16px; }
        .header { display: flex; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 32px; }
        .header-left { max-width: 60%; }
        .title { font-size: 28px; font-weight: 700; margin-bottom: 8px; }
        .company-name { font-size: 16px; font-weight: 700; color: #111827; margin-bottom: 6px; }
        .company-address { font-size: 12px; color: #4b5563; line-height: 1.6; }
        .invoice-meta { text-align: right; min-width: 220px; }
        .invoice-meta p { margin: 0 0 8px; font-size: 13px; color: #374151; }
        .invoice-meta strong { color: #111827; }
        .section-title { font-size: 18px; font-weight: 700; color: #111827; margin-bottom: 16px; }
        .info-grid { display: flex; justify-content: space-between; gap: 24px; flex-wrap: wrap; margin-bottom: 32px; }
        .info-box { width: 100%; max-width: 46%; }
        .info-box p { margin: 4px 0; font-size: 13px; color: #374151; }
        .info-box strong { color: #111827; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #e5e7eb; padding: 12px 10px; }
        th { background: #f9fafb; text-align: left; font-size: 13px; color: #374151; }
        td { font-size: 13px; color: #111827; vertical-align: top; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .summary { margin-top: 24px; width: 100%; }
        .summary-row { display: flex; justify-content: space-between; padding: 10px 0; border-top: 1px solid #e5e7eb; }
        .summary-row:first-child { border-top: none; }
        .summary-row.total { font-size: 15px; font-weight: 700; }
        .footer-grid { display: flex; justify-content: space-between; gap: 24px; flex-wrap: wrap; margin-top: 48px; }
        .footer-box { width: 100%; max-width: 46%; }
        .footer-box p { margin: 6px 0; font-size: 13px; color: #374151; }
    </style>
</head>
<body>
    <?php
        $header = isset($transaction['header']) ? $transaction['header'] : $transaction;
        $details = isset($transaction['details']) ? $transaction['details'] : [];
    ?>
    <div class="container">
        <div class="card">
            <div class="header">
                <div class="header-left">
                    <div class="title">Invoice</div>
                    <div class="company-name">PT Bhinneka Sangkuriang Transport</div>
                    <div class="company-address">Jl. Gedebage Selatan No.121A, Cisaranten Kidul, Kec. Gedebage, Kota Bandung, Jawa Barat 40552</div>
                </div>
                <div class="invoice-meta">
                    <p><strong>No. Faktur:</strong> <?= esc($header->invoice_number) ?></p>
                    <p><strong>Invoice Date:</strong> <?= date('d F Y', strtotime($header->invoice_date)) ?></p>
                    <p><strong>Updated:</strong> <?= date('d F Y', strtotime($header->updated_at)) ?></p>
                </div>
            </div>

            <div class="section-title">Invoice Detail</div>
            <div class="info-grid">
                <div class="info-box">
                    <p><strong>Kepada Yth:</strong></p>
                    <p><?= esc($header->company_name ?? 'N/A') ?></p>
                    <p><?= esc($header->address ?? 'N/A') ?></p>
                    <p><strong>Up :</strong> <?= esc($header->pic_name) ?></p>
                </div>
                <div class="info-box">
                    <p><strong>PIC Name:</strong> <?= esc($header->pic_name) ?></p>
                    <p><strong>Customer:</strong> <?= esc($header->company_name ?? 'N/A') ?></p>
                </div>
            </div>

            <div class="section-title">Items</div>
            <table>
                <thead>
                    <tr>
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th>Unit</th>
                        <th class="text-right">Unit Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($details)): ?>
                        <?php foreach ($details as $detail): ?>
                            <tr>
                                <td><?= esc($detail->product_code ?? 'N/A') ?></td>
                                <td><?= esc($detail->product_name ?? 'N/A') ?></td>
                                <td><?= esc($detail->unit ?? 'N/A') ?></td>
                                <td class="text-right">IDR <?= number_format($detail->price ?? 0, 0, ',', '.') ?></td>
                                <td class="text-center"><?= $detail->qty ?></td>
                                <td class="text-right">IDR <?= number_format(($detail->price ?? 0) * $detail->qty, 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No items found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="summary">
                <div class="summary-row">
                    <span>Total Quantity</span>
                    <span><?= $transaction['totalQuantity'] ?? 0 ?></span>
                </div>
                <div class="summary-row total">
                    <span>Grand Total</span>
                    <span>IDR <?= number_format($header->grand_total ?? 0, 0, ',', '.') ?></span>
                </div>
            </div>

            <div class="footer-grid">
                <div class="footer-box">
                    <p><strong>Purchasing:</strong></p>
                    <p><?= esc(auth()->user()->username ?? 'N/A') ?></p>
                </div>
                <div class="footer-box text-right">
                    <p><strong>Location & Date:</strong></p>
                    <p>Cirebon, <?= date('d F Y', strtotime($header->updated_at)) ?></p>
                    <p><?= esc($header->pic_name) ?></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
