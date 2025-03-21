<!DOCTYPE html>
<html>

<head>
    <title>Pengaktifan Akaun</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 650px;
            margin: auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .arabic_text {
            text-align: center;
            margin-bottom: 40px;
        }

        .title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .content {
            font-size: 16px;
            color: #000;
            text-align: left;
        }

        .info-box {
            margin-top: 20px;
            display: inline-block;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 5px 10px;
            font-size: 16px;
            color: #000;
        }

        .bold {
            font-weight: bold;
        }

        .footer {
            font-size: 14px;
            color: #000;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Logo -->
        <div class="logo">
            <img src="{{ $message->embed(public_path('subscription/assets/icons/logo_.png')) }}" alt="Logo" />
        </div>

        <!-- Title -->
        <div class="title">SISTEM LANGGANAN MAIS</div>

        <div class="arabic_text">
            <img src="{{ $message->embed(public_path('subscription/assets/icons/arabic_text.png')) }}" alt="Logo" />
        </div>

        <!-- Greeting -->
        <div class="content">
            <p>Terima kasih kerana berminat untuk mendaftar ke sistem ini.</p>
            <p>Pihak kami sedang menyemak permohonan anda. Sila semak semula emel anda dalam masa 3 hari bekerja.</p>
        </div>
    </div>
</body>

</html>
