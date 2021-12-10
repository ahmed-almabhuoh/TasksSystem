<?php

namespace App\Mail;

use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    // public Admin $admin;
    protected Admin $admin;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Admin $admin)
    {
        //
        $this->admin = $admin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->
        from('hr@tasks-system.com')
        ->subject('Tasks System | Welcome E-mail')
        // I will use with if the data is protected
        ->with([
            'admin' => $this->admin,
            'admin_name' => $this->admin->name,
        ])
        ->markdown('cms.emails.welcome');
    }
}
