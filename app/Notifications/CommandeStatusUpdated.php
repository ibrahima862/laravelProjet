<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Commande;

class CommandeStatusUpdated extends Notification
{
    use Queueable;

    protected $commande;

    public function __construct(Commande $commande)
    {
        $this->commande = $commande;
    }

    // can be mail, database, broadcast etc.
    public function via($notifiable)
    {
        return ['mail', 'database']; // On envoie un mail et on garde un enregistrement
    }

   public function toMail($notifiable)
{
    return (new MailMessage)
                ->subject("Mise à jour de votre commande #{$this->commande->id}")
                ->greeting("Bonjour {$notifiable->name},")
                ->line("Le statut de votre commande a été mis à jour : **{$this->commande->status}**.")
                ->action('Voir ma commande', url('/commandes/' . $this->commande->id))
                ->line('Merci pour votre confiance !');
}

    public function toDatabase($notifiable)
{
    return [
        'commande_id' => $this->commande->id,
        'status' => $this->commande->status,
        'message' => "Le statut de votre commande #{$this->commande->id} a été mis à jour.",
    ];
}

    
}
