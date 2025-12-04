<h1>Liste des produits</h1>
 <style>
        table {
            width: 80%;
            margin: 40px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background: #f0f0f0;
            text-align: center
        }
    </style>
     <table>
    <thead>
    <tr>
    <th>id</th>
    <th>nom</th>
    <th>prix</th>
    <th>quantite</th>
    </tr>
    </thead>
    <tbody>
@foreach ($produits as $produit)
    <tr>
    <td>{{ $produit->id }}</td>
    <td>{{ $produit->nom }}</td>
    <td>{{ $produit->prix }}</td>
    <td>{{ $produit->quantite }}</td>
    </tr>
@endforeach
    </tbody>

   </table>

