<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Cerere servicii</title>
</head>
<body style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">

    <h2 style="color: #1d4ed8;">Cerere noua de servicii contabilitate</h2>

    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="padding: 8px; font-weight: bold; width: 150px;">Nume:</td>
            <td style="padding: 8px;">{{ $numeClient }}</td>
        </tr>
        <tr style="background: #f3f4f6;">
            <td style="padding: 8px; font-weight: bold;">Email:</td>
            <td style="padding: 8px;">{{ $emailClient }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; font-weight: bold;">Telefon:</td>
            <td style="padding: 8px;">{{ $telefonClient }}</td>
        </tr>
        <tr style="background: #f3f4f6;">
            <td style="padding: 8px; font-weight: bold;">Mesaj:</td>
            <td style="padding: 8px;">{{ $mesajClient }}</td>
        </tr>
    </table>

    <p style="color: #6b7280; font-size: 12px; margin-top: 30px;">
        Acest email a fost trimis automat de pe site-ul tau de contabilitate.
    </p>

</body>
</html>