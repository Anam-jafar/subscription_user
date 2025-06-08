<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $invoiceData['invoice']['title'] ?? 'Invoice' }}</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      line-height: 1.4;
      color: #333;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }

    .header {
      width: 100%;
      margin-bottom: 30px;
      border-bottom: 2px solid #ddd;
      padding-bottom: 20px;
    }

    .header-content {
      width: 100%;
      display: table;
      table-layout: fixed;
    }

    .logo-cell {
      display: table-cell;
      width: 100px;
      vertical-align: top;
      padding-right: 20px;
    }

    .info-cell {
      display: table-cell;
      vertical-align: top;
    }

    .logo {
      width: 60px;
      height: 90px;
    }

    /* Info Row - Company and Invoice side by side using table layout */
    .info-row {
      width: 100%;
      display: table;
      table-layout: fixed;
    }

    .company-info {
      display: table-cell;
      width: 50%;
      vertical-align: top;
      padding-right: 20px;
    }

    .company-name {
      font-size: 16px;
      font-weight: bold;
      color: rgb(44, 62, 85);
      margin-bottom: 5px;
    }

    .company-details {
      font-size: 10px;
      line-height: 1.3;
    }

    .document-info {
      display: table-cell;
      width: 50%;
      vertical-align: top;
      text-align: right;
    }

    .document-title {
      font-size: 24px;
      font-weight: bold;
      color: rgb(44, 62, 85);
      margin-bottom: 10px;
    }

    .document-details {
      font-size: 11px;
    }

    .document-details div {
      margin-bottom: 3px;
    }

    .invoice-to {
      margin-bottom: 20px;
    }

    .invoice-to-title {
      font-weight: bold;
      margin-bottom: 5px;
      color: rgb(44, 62, 85);
      font-size: 16px;
    }

    .customer-info,
    .invoice-info {
      background-color: #e9ecef;
      padding: 10px;
      border-radius: 3px;
    }

    .attention-section {
      margin: 20px 0;
      padding: 10px;
      background-color: #f0f0f0;
      border-radius: 3px;
    }

    .attention-title {
      font-weight: bold;
      margin-bottom: 5px;
    }

    .items-table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
    }

    .items-table th {
      background-color: #e9ecef;
      padding: 10px 8px;
      text-align: left;
      font-weight: bold;
      border: 1px solid #ddd;
    }

    .items-table td {
      padding: 8px;
      border: 1px solid #ddd;
      vertical-align: top;
    }

    .items-table tr:nth-child(even) {
      background-color: #f8f9fa;
    }

    .text-center {
      text-align: center;
    }

    .text-right {
      text-align: right;
    }

    .totals-section {
      margin-top: 20px;
      float: right;
      width: 300px;
    }

    .totals-table {
      width: 100%;
      border-collapse: collapse;
    }

    .totals-table td {
      padding: 5px 10px;
      border: 1px solid #ddd;
    }

    .totals-table .total-label {
      font-weight: bold;
      background-color: #e9ecef;
    }

    .totals-table .total-amount {
      text-align: right;
      font-weight: bold;
    }

    .footer {
      clear: both;
      margin-top: 50px;
      padding-top: 20px;
      border-top: 1px solid #ddd;
    }

    .footer-note {
      font-style: italic;
      text-align: center;
      margin-bottom: 10px;
      font-size: 10px;
      color: #666;
    }

    .system-info {
      text-align: center;
      font-size: 9px;
      color: #888;
    }

    .clearfix::after {
      content: "";
      display: table;
      clear: both;
    }
  </style>
</head>

<body>
  <div class="container">
    <!-- Header Section -->
    <div class="header">
      <div class="header-content">

        <!-- Logo Cell -->
        <div class="logo-cell">
          <img src="{{ public_path('subscription/assets/icons/logo_.png') }}" alt="Logo" class="logo">
        </div>

        <!-- Info Cell -->
        <div class="info-cell">
          <div class="info-row">

            <!-- Company Info (Left Side) -->
            <div class="company-info">
              <div class="company-name">{{ $invoiceData['company']['name'] }}</div>
              <div class="company-details">
                {{ $invoiceData['company']['address_line_1'] }}<br>
                {{ $invoiceData['company']['address_line_2'] }}<br>
                {{ $invoiceData['company']['address_line_3'] }}<br>
                Tel: {{ $invoiceData['company']['phone'] }} Fax: {{ $invoiceData['company']['fax'] }}<br>
                Web: {{ $invoiceData['company']['website'] }}
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <!-- Invoice To Section -->
    <div class="invoice-to">

      <table class="invoice-details" width="100%" cellpadding="0" cellspacing="0">
        <tr>
          <!-- Left Side -->
          <td class="customer-info" width="48%">
            <span class="invoice-to-title"> <strong>Invois Kepada</strong> </span><br>
            {{ $invoiceData['customer']['name'] }}<br>
            {{ $invoiceData['customer']['address_line_1'] }}<br>
            @if (!empty($invoiceData['customer']['address_line_2']))
              {{ $invoiceData['customer']['address_line_2'] }}<br>
            @endif
            {{ $invoiceData['customer']['postal_code'] }}<br>
            {{ $invoiceData['customer']['state'] }}<br>
            {{ $invoiceData['customer']['country'] }}
          </td>

          <td width="4%"></td> <!-- spacer -->

          <!-- Right Side -->
          <td class="invoice-info" width="48%">
            <span class="invoice-to-title"><strong>{{ $invoiceData['invoice']['title'] }}</strong></span><br><br>

            <table width="100%" cellpadding="2" cellspacing="0">
              <tr>
                <td width="100px">Tarikh</td>
                <td>: {{ $invoiceData['invoice']['date'] }}</td>
              </tr>
              <tr>
                <td>No. Invois</td>
                <td>: {{ $invoiceData['invoice']['number'] }}</td>
              </tr>
              <tr>
                <td>Diproses Oleh</td>
                <td>: {{ $invoiceData['invoice']['processed_by'] }}</td>
              </tr>

              <tr>
                <td>Nama Wakil</td>
                <td>: {{ $invoiceData['customer']['officer'] }}</td>
              </tr>
              <tr>
                <td>No. Telefone</td>
                <td>: {{ $invoiceData['customer']['phone'] }}</td>
              </tr>
            </table>
          </td>

        </tr>
      </table>
    </div>

    <!-- Items Table -->
    <table class="items-table">
      <thead>
        <tr>
          <th width="5%">Bil</th>
          <th width="50%">Keterangan</th>
          <th width="15%" class="text-right">Harga (RM)</th>
          <th width="10%" class="text-center">Unit</th>
          <th width="20%" class="text-right">Jumlah (RM)</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($invoiceData['items'] as $item)
          <tr>
            <td class="text-center">{{ $item['bil'] }}</td>
            <td>{{ $item['description'] }}</td>
            <td class="text-right">{{ number_format($item['price'], 2) }}</td>
            <td class="text-center">{{ $item['unit'] }}</td>
            <td class="text-right">{{ number_format($item['total'], 2) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <!-- Totals Section -->
    <div class="totals-section">
      <table class="totals-table">
        <tr>
          <td class="total-label">Jumlah Invois</td>
          <td class="total-amount">{{ number_format($invoiceData['totals']['subtotal'], 2) }}</td>
        </tr>
        <tr>
          <td class="total-label">Jumlah Bayaran</td>
          <td class="total-amount">{{ number_format($invoiceData['totals']['paid'], 2) }}</td>
        </tr>
        <tr>
          <td class="total-label">Baki Tunggakan (RM)</td>
          <td class="total-amount">{{ number_format($invoiceData['totals']['total'], 2) }}</td>
        </tr>
      </table>
    </div>

    <!-- Footer -->
    <div class="footer clearfix">
      <div class="footer-note">
        {{ $invoiceData['footer_note'] }}
      </div>
      <div class="system-info">
        {{ $invoiceData['system_info'] }}
      </div>
    </div>
  </div>
</body>

</html>
