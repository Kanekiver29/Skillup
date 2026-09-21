<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage as NotifyBroadcastMessage;

class NewLessonNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected $lesson;
    protected $module;
    protected $course;

    public function __construct($lesson, $module, $course = null)
    {
        $this->lesson = $lesson;
        $this->module = $module;
        $this->course = $course ?: ($module->course ?? null);
    }

    public function via($notifiable)
    {
        return collect(['database', 'mail', 'broadcast'])
            ->filter(fn (string $channel) => $notifiable->receivesNotificationChannel($channel))
            ->values()
            ->all();
    }

    public function toMail($notifiable)
    {
        $courseTitle = $this->course->title ?? 'a course';
        $moduleTitle = $this->module->title ?? 'a module';

        $url = $this->course && $this->module
            ? route('modules.show', [$this->course->slug, $this->module->slug])
            : url('/');

        return (new MailMessage)
            ->subject("New material added to {$courseTitle}")
            ->greeting('Hello!')
            ->line("New content '{$this->lesson->title}' was added to the module '{$moduleTitle}' in {$courseTitle}.")
            ->action('View Module', $url)
            ->line('Thank you for learning with us!');
    }

    public function toArray($notifiable)
    {
        return [
            'lesson_id' => $this->lesson->id ?? null,
            'lesson_title' => $this->lesson->title ?? null,
            'module_id' => $this->module->id ?? null,
            'module_title' => $this->module->title ?? null,
            'course_id' => $this->course->id ?? null,
            'course_title' => $this->course->title ?? null,
            'url' => $this->course && $this->module ? route('modules.show', [$this->course->slug, $this->module->slug]) : null,
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast($notifiable)
    {
        return new NotifyBroadcastMessage($this->toArray($notifiable));
    }
}
