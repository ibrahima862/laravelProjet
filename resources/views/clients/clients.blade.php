<h1>Liste des clients</h1>
@foreach ($clients as $client)
    <p>{{ $client->nom }} {{ $client->prenom }}</p>
@endforeach
