<p>Hi {{ $booking->occurrence->template->room->user->name }},</p>
<p>{{ $booking->user->name }} booked a spot in {{ $booking->occurrence->template->title }} scheduled for
    {{ $booking->occurrence->start_at }}.</p>