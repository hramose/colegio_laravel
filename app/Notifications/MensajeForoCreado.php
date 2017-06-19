<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\App\Entities\Estudiante;
use App\App\Entities\MensajeForo;

class MensajeForoCreado extends Notification
{
    use Queueable;

    public $estudiante;
    public $mensaje;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Estudiante $estudiante, MensajeForo $mensaje)
    {
        $this->estudiante = estudiante;
        $this->mensaje = $mensaje;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toDatabase($notifiable)
    {
        $descripcion = 'Hola <b>' . $this->estudiante->nombre_completo.'! </b>';
        $descripcion .= '<br/><br/>' ;
        $descripcion .= 'La actividad ' . $this->actividad->titulo .' ha sido creada en tu curso ' . $this->actividad->unidad_curso->curso->materia->descripcion.'.<br/><br/>';

        $user = \Auth::user();
        return [
            'titulo' => 'Actividad agregada',
            'descripcion' => $descripcion,
            'icon' => 'fa-book',
            'user' => $user->username,
            'created_by' => $user->persona->nombre_completo,
            'created_by_id' => $user->persona_id
        ];
    }
}
