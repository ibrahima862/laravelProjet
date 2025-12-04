<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande Validée</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
        }

        .success-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 60px 20px;
        }

        .success-card {
            background: #fff;
            padding: 40px;
            max-width: 500px;
            width: 100%;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .success-card .icon {
            font-size: 60px;
            color: #28a745;
            margin-bottom: 20px;
        }

        .success-card h1 {
            font-size: 28px;
            margin-bottom: 15px;
        }

        .success-card .message {
            font-size: 17px;
            color: #555;
            margin-bottom: 20px;
        }

        .success-card .order-info {
            font-size: 16px;
            color: #333;
            margin-bottom: 30px;
        }

        .btn-home, .btn-view-order {
            display: inline-block;
            padding: 12px 25px;
            background: #0066ff;
            color: white;
            border-radius: 8px;
            font-size: 16px;
            text-decoration: none;
            transition: 0.3s;
            margin: 5px;
        }

        .btn-home:hover, .btn-view-order:hover {
            background: #004bcc;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-card">

            <div class="icon">✔</div>

            <h1>Commande Validée !</h1>

            <p class="message">
                Merci pour votre achat. Votre commande a bien été enregistrée.  
                Nous vous contacterons bientôt pour la livraison.
            </p>

            <div class="order-info">
                Numéro de commande : <strong>#{{ $commande->id }}</strong><br>
                Montant total : <strong>{{ number_format($commande->total, 0) }} CFA</strong>
            </div>

            <a href="{{ route('commandes.index', $commande->id) }}" class="btn-view-order">Voir mes commande</a>
            <a href="{{ route('index.home') }}" class="btn-home">Retour à l'accueil</a>

        </div>
    </div>
</body>
</html>
