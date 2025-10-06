<p>Hi {{ $booking->user->name }},</p>
<p>Your booking is confirmed for {{ $booking->occurrence->template->title }} at {{ $booking->occurrence->start_at }}.
</p>